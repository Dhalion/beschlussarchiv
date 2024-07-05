<?php

namespace App\Http\Controllers\Api\V3;

use App\Models\Council;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V3\StoreCouncilRequest;

class CouncilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Council::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouncilRequest $request)
    {
        $council = Council::create($request->all());
        return response()->json($council, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Council $council)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Council $council)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Council $council)
    {
        //
    }
}
