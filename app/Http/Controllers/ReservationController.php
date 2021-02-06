<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
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
        };

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

        return response()->json([
            "status"      => 201,
            "message"     => "Successfully created.",
            "response"    => ['reservation' => $reservation]
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $reservation = Reservation::where('id', $id)->first();

        if( ! $reservation) {
            return response()->json([
                "status"  => 404,
                "error"   => "Not Found",
                "message" => "The reservation was not found."
            ], 404);
        }

        $response = ['reservation' => $reservation];

        if($reservation->status == Reservation::STATUSES['waiting']) {
            $response['positionInQueue'] = $reservation->getPosInQueue();
            $response['estimatedWaitingTime'] = $reservation->getEstimatedWaitingTime();
        }

        return response()->json([
            "status"   => 200,
            "response" => $response
        ], 200);
    }

    /**
     * Cancel the specified resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Request $request, $id)
    {
        $reservation = Reservation::where([
            ['id', $id],
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
