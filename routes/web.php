<?php

use App\Models\Category;
use App\Livewire\MainPage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResolutionFrontendController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Resolutions;
use App\Livewire\Ckeditor;

Route::get('/', MainPage::class);

Route::get('/resolution/{parameter}', [ResolutionFrontendController::class, 'resolveResolution']);

Route::get('/council/{councilId}/resolution/{parameter}', [ResolutionFrontendController::class, 'resolveResolutionWithCouncil']);


Route::get('/category/{id}', function ($id) {
    return view('page.category', [
        'category' => Category::findOrFail($id)->load('resolutions')
    ]);
});


// admin routes
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', Dashboard::class)->name('admin.dashboard');
    Route::get('/resolutions', Resolutions::class)->name('admin.resolutions');
    Route::get('/ckeditor', Ckeditor::class)->name('admin.ckeditor');
});
