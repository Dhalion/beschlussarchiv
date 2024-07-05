<?php

namespace App\Http\Controllers\Api\V3;

use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V3\StoreApplicantRequest;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Applicant::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicantRequest $request)
    {
        $applicant = Applicant::create($request->all());
        return response()->json($applicant, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Applicant $applicants)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Applicant $applicants)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Applicant $applicants)
    {
        //
    }
}
