<?php

use App\Models\Category;
use App\Livewire\MainPage;
use App\Livewire\Ckeditor;
use App\Livewire\Admin\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResolutionFrontendController;
use App\Livewire\Admin\Applicants\Index as ApplicantsIndex;
use App\Livewire\Admin\Categories\Index as CategoriesIndex;
use App\Livewire\Admin\Resolutions\Edit;
use App\Livewire\Admin\Resolutions\Index;

Route::get('/', MainPage::class);

Route::get('/resolution/{parameter}', [ResolutionFrontendController::class, 'resolveResolution'])->name('resolution');

Route::get('/council/{councilId}/resolution/{parameter}', [ResolutionFrontendController::class, 'resolveResolutionWithCouncil']);


Route::get('/category/{id}', function ($id) {
    return view('page.category', [
        'category' => Category::findOrFail($id)->load('resolutions')
    ]);
});


// admin routes
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', Dashboard::class)->name('admin.dashboard');
    Route::get('/resolutions', Index::class)->name('admin.resolutions.index');
    Route::get('/resolutions/{id}', Edit::class)->name('admin.resolutions.edit');

    Route::get('/categories', CategoriesIndex::class)->name('admin.categories.index');

    Route::get('/applicants', ApplicantsIndex::class)->name('admin.applicants.index');
});
