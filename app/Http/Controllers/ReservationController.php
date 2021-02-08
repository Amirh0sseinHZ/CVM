<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $waiting  = Reservation::where('status', Reservation::STATUSES['waiting'])
            ->take((int) $request->input('limit') ? $request->input('limit') : 5)
            ->get();
        $handling = Reservation::where('status', Reservation::STATUSES['handling'])
            ->get();

        return response()->json([
            "status"       => 200,
            "response"     => ['reservations' => [
                "handling" => $handling,
                "waiting"  => $waiting
            ]]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $customerHasActiveReservation = Reservation::where(function($query) {
            $query->where('status', Reservation::STATUSES['waiting']);
            $query->orWhere('status', Reservation::STATUSES['handling']);
        })->where('customer_id', $request->session()->getId())
            ->first();

        if($customerHasActiveReservation) {
            return response()->json([
                "status"  => 409,
                "error"   => "Conflict",
                "message" => "This session already has an active reservation. You may first cancel the reservation in order to book another one."
            ], 409);
        }

        $validator = Validator::make($request->all(), [
            'specialist_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status"  => 404,
                "error"   => "Not Found",
                "message" => "The specialist was not found."
            ], 404);
        }

        $reservation = new Reservation;
        $reservation->specialist_id  = $request->specialist_id;
        $reservation->customer_id    = $request->session()->getId();
        $reservation->save();

        $reservation->code = $reservation->specialist_id."_".$reservation->id;

        return response()->json([
            "status"      => 201,
            "message"     => "Successfully created.",
            "response"    => ['reservation' => $reservation]
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $code
     * @return JsonResponse
     */
    public function show(Request $request, $code)
    {
        $arr          = explode('_', $code);
        $resvId       = $arr[1];
        $specialistId = $arr[0];

        $reservation = Reservation::where([
            ['id', $resvId],
            ['specialist_id', $specialistId]
        ])->first();

        if( ! $reservation) {
            return response()->json([
                "status"  => 404,
                "error"   => "Not Found",
                "message" => "The reservation was not found."
            ], 404);
        }

        $response = ['reservation' => $reservation];

        if($reservation->status == Reservation::STATUSES['waiting']) {
            $response['positionInQueue']      = $reservation->getPosInQueue();
            $response['estimatedWaitingTime'] = $reservation->getEstimatedWaitingTime();
            $response['canBeCanceled']        = $reservation->customer_id == $request->session()->getId()
                ? true : false;
        } else {
            $response['canBeCanceled'] = false;
        }

        $response['reservation']['code'] = $reservation->specialist_id."_".$reservation->id;

        return response()->json([
            "status"   => 200,
            "response" => $response
        ], 200);
    }

    /**
     * Display the active resource of requester
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function showActive(Request $request)
    {
        $reservation = Reservation::where([
            ['customer_id', $request->session()->getId()],
            ['status', Reservation::STATUSES['waiting']]
        ])->first();

        if(! $reservation) {
            return response()->json("", 404);
        }

        return response()->json([
            "code" => $reservation->specialist_id."_".$reservation->id
        ],200);
    }

    /**
     * Cancel the specified resource.
     *
     * @param Request $request
     * @param $code
     * @return JsonResponse
     */
    public function cancel(Request $request, $code)
    {
        $arr          = explode('_', $code);
        $resvId       = $arr[1];
        $specialistId = $arr[0];

        $reservation = Reservation::where([
            ['id', $resvId],
            ['specialist_id', $specialistId],
            ['customer_id', $request->session()->getId()],
            ['status', Reservation::STATUSES['waiting']]
        ])->first();

        if( ! $reservation) {
            return response()->json([
                "status"  => 404,
                "error"   => "Not Found",
                "message" => "The reservation was not found."
            ], 404);
        }

        $reservation->status = Reservation::STATUSES['canceled'];
        $reservation->save();

        return response()->json([
            "status"   => 200,
            "message"  => "Canceled successfully!",
            "response" => ['reservation' => $reservation]
        ], 200);
    }
}
