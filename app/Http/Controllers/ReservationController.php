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
            ->orderBy('created_at')
            ->take((int) $request->input('limit') ? $request->input('limit') : 5)
            ->get();
        $handling = Reservation::where('status', Reservation::STATUSES['handling'])
            ->orderByDesc('updated_at')
            ->get();

        return response()->json([
            "handling" => $handling,
            "waiting"  => $waiting
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
        $validator = Validator::make($request->all(), [
            'specialist_id' => 'required|integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "The requested specialist was not found."
            ], 404);
        }

        $reservation = new Reservation;
        $reservation->specialist_id = $request->specialist_id;
        $reservation->save();

        return response()->json($reservation, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $code
     * @return JsonResponse
     */
    public function show($code)
    {
        $arr          = explode('-', $code);
        $resvId       = $arr[1];
        $specialistId = $arr[0];

        $reservation = Reservation::where([
            ['id', $resvId],
            ['specialist_id', $specialistId]
        ])->first();

        if( ! $reservation) {
            return response()->json([
                "message" => "The reservation was not found."
            ], 404);
        }

        $response = ['reservation' => $reservation];

        if($reservation->status == Reservation::STATUSES['waiting']) {
            $response['queue']['items']      = $reservation->specialist->getWaitingReservations();
            $response['queue']['position']   = $reservation->getPosInQueue();
            $response['queue']['estimation'] = $reservation->getEstimatedWaitingTime();
        }

        return response()->json($response, 200);
    }

    /**
     * Cancel the specified resource.
     *
     * @param $code
     * @return JsonResponse
     */
    public function cancel($code)
    {
        $arr          = explode('-', $code);
        $resvId       = $arr[1];
        $specialistId = $arr[0];

        $reservation = Reservation::where([
            ['id', $resvId],
            ['specialist_id', $specialistId],
            ['status', Reservation::STATUSES['waiting']]
        ])->first();

        if( ! $reservation) {
            return response()->json([
                "message" => "No reservation was not found."
            ], 404);
        }

        $reservation->status = Reservation::STATUSES['canceled'];
        $reservation->save();

        return response()->json($reservation, 200);
    }
}
