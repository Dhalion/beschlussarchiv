<?php

use App\Models\Category;
use App\Livewire\MainPage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResolutionFrontendController;

Route::get('/', MainPage::class);

Route::get('/resolution/{parameter}', [ResolutionFrontendController::class, 'resolveResolution']);

Route::get('/council/{councilId}/resolution/{parameter}', [ResolutionFrontendController::class, 'resolveResolutionWithCouncil']);


Route::get('/category/{id}', function ($id) {
    return view('page.category', [
        'category' => Category::findOrFail($id)->load('resolutions')
    ]);
});
