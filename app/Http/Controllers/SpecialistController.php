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

        return response()->json([
            "status"   => 200,
            "response" => ['specialists' => $specialists]
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {

    }
}
