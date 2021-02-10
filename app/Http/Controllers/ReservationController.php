<?php

namespace App\Http\Controllers;

use App\Exceptions\ResourceNotFound404Exception;
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
        $waiting = Reservation::where('status', Reservation::STATUSES['waiting'])
            ->orderBy('created_at')
            ->take((int)$request->input('limit') ? $request->input('limit') : 5)
            ->get();
        $handling = Reservation::where('status', Reservation::STATUSES['handling'])
            ->orderByDesc('updated_at')
            ->get();

        return response()->json([
            "handling" => $handling,
            "waiting" => $waiting
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

        if ($validator->fails())
            throw new ResourceNotFound404Exception();

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
        $reservation = $this->getReservationOr404($code, Reservation::STATUSES['waiting']);

        $response = ['reservation' => $reservation];

        if ($reservation->status == Reservation::STATUSES['waiting']) {
            $response['queue']['items'] = $reservation->specialist->getWaitingReservations();
            $response['queue']['position'] = $reservation->getPosInQueue();
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
        $reservation = $this->getReservationOr404($code, Reservation::STATUSES['waiting']);
        $reservation->status = Reservation::STATUSES['canceled'];
        $reservation->save();

        return response()->json($reservation, 200);
    }

    /**
     * Handle the specified resource.
     *
     * @param $code
     * @return JsonResponse
     */
    public function handle($code)
    {
        $reservation = $this->getReservationOr404($code, Reservation::STATUSES['waiting']);
        $reservation->status = Reservation::STATUSES['handling'];
        $reservation->save();

        return response()->json($reservation, 200);
    }

    /**
     * End the specified resource.
     *
     * @param $code
     * @return JsonResponse
     */
    public function end($code)
    {
        $reservation = $this->getReservationOr404($code, Reservation::STATUSES['handling']);
        $reservation->status = Reservation::STATUSES['served'];
        $reservation->save();

        return response()->json($reservation, 200);
    }

    /*
     * Get the specific resource by its code identifier. If not exists, returns 404
     */
    protected function getReservationOr404($code, $status = null)
    {
        $arr = explode('-', $code);
        $resvId = $arr[1];
        $specialistId = $arr[0];

        $reservation = Reservation::where([
            ['id', $resvId],
            ['specialist_id', $specialistId],
            $status !== null ? ['status', $status] : []
        ])->first();

        if( ! $reservation)
            throw new ResourceNotFound404Exception;

        return $reservation;
    }
}
