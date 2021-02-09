<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class SpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $specialists = User::all();

        foreach ($specialists as $specialist) {
            $specialist->awaiting = $specialist->getWaitingReservations()->count();
        }

        return response()->json($specialists, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $specialist = User::where('id', (int) $id)->first();

        if( ! $specialist) {
            return response()->json([
                "message" => "The specialist was not found."
            ], 404);
        }

        $response = ['specialist' => $specialist];

        $response['reservations']['waiting'] = $specialist->getWaitingReservations();
        $response['reservations']['handling'] = $specialist->getCurrentSession();


        return response()->json($response, 200);
    }
}
