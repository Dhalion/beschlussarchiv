<?php

use App\Models\Category;
use App\Livewire\MainPage;
use App\Livewire\Admin\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResolutionFrontendController;
use App\Livewire\Admin\Applicants\Index as ApplicantsIndex;
use App\Livewire\Admin\Auth\Login;
use App\Livewire\Admin\Categories\Index as CategoriesIndex;
use App\Livewire\Admin\Councils\Create as CouncilsCreate;
use App\Livewire\Admin\Resolutions\Index as ResolutionsIndex;
use App\Livewire\Admin\Resolutions\Edit as ResolutionsEdit;
use App\Livewire\Admin\Resolutions\Create as ResolutionsCreate;
use App\Livewire\Admin\Councils\Index as CouncilsIndex;
use App\Livewire\CategoryPage;
use App\Models\Applicant;

Route::get('/', MainPage::class)->name('frontend.main');

Route::get('/resolution/{parameter}', [ResolutionFrontendController::class, 'resolveResolution'])->name('frontend.resolution');

Route::get('/council/{councilId}/resolution/{parameter}', [ResolutionFrontendController::class, 'resolveResolutionWithCouncil']);


Route::get('/category/{parameter}', CategoryPage::class)->name('frontend.category');

Route::get('/applicant/{id}', function ($id) {
    return view('page.applicant', [
        'applicant' => Applicant::findOrFail($id)
            ->load('resolutions')
    ])->layout('layouts.app');
})->name('frontend.applicant');



Route::get('/admin/login', Login::class)->name('login');
Route::get('/admin/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');


// admin routes
Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth']
], function () {
    Route::get('/', Dashboard::class)->name('admin.dashboard');


    Route::get('/resolutions', ResolutionsIndex::class)->name('admin.resolutions.index');

    Route::get('/resolutions/create', ResolutionsEdit::class)
        ->name('admin.resolutions.create')
        ->defaults('createNew', true);

    Route::get('/resolutions/{resolutionId}', ResolutionsEdit::class)->name('admin.resolutions.edit');


    Route::get('/categories', CategoriesIndex::class)->name('admin.categories.index');

    Route::get('/applicants', ApplicantsIndex::class)->name('admin.applicants.index');

    Route::get('/councils', CouncilsIndex::class)->name('admin.councils.index')->can('viewAny', \App\Models\Council::class);
    Route::get('/councils/create', CouncilsCreate::class)->name('admin.councils.create')->can('create', \App\Models\Council::class);
});
