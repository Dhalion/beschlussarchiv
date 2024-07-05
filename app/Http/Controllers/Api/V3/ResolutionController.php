<?php

namespace App\Http\Controllers\Api\V3;

use App\Models\Resolution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V3\ResolutionResource;
use App\Http\Resources\V3\ResolutionCollection;
use App\Http\Requests\V3\StoreResolutionRequest;

class ResolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ResolutionCollection(Resolution::paginate());
    }

    public function search(Request $request)
    {
        $searchQuery = $request->query("q");
        if (!$searchQuery) {
            return response()->json([
                "message" => "Query parameter 'q' is required"
            ], 400);
        }
        return Resolution::search($searchQuery)->raw();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResolutionRequest $request)
    {
        $resolutionData = $request->except('applicantsIds');
        $resolution = Resolution::create($resolutionData);
        $resolution->applicants()->attach($request->applicantsIds);

        return response()->json($resolution, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Resolution $resolution)
    {
        return new ResolutionResource($resolution);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resolution $resolution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resolution $resolution)
    {
        //
    }
}
