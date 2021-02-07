<?php

namespace App\Http\Controllers;

use App\Models\User;

class SpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $specialists = User::all();

        return response()->json([
            "status"      => 200,
            "response"    => ['specialists' => $specialists]
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

    }
}
