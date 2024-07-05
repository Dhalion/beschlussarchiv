<?php

use App\Http\Controllers\Api\V3\ApplicantController;
use App\Http\Controllers\Api\V3\CategoryController;
use App\Http\Controllers\Api\V3\CouncilController;
use App\Http\Controllers\Api\V3\ResolutionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// API Routes Version 3: /api/v3/
Route::group(
    ['prefix' => 'v3'],
    function () {
        Route::get('resolutions/search', [ResolutionController::class, 'search']);
        Route::apiResource('resolutions', ResolutionController::class);
        Route::apiResource('applicants', ApplicantController::class);
        Route::apiResource('councils', CouncilController::class);
        Route::apiResource('categories', CategoryController::class);
    }
);
