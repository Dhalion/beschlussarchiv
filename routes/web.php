<?php

use App\Models\Category;
use App\Livewire\MainPage;
use App\Livewire\Admin\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResolutionFrontendController;
use App\Livewire\Admin\Applicants\Index as ApplicantsIndex;
use App\Livewire\Admin\Auth\Login;
use App\Livewire\Admin\Categories\Index as CategoriesIndex;
use App\Livewire\Admin\Resolutions\Index as ResolutionsIndex;
use App\Livewire\Admin\Resolutions\Edit as ResolutionsEdit;
use App\Livewire\Admin\Resolutions\Create as ResolutionsCreate;

Route::get('/', MainPage::class);

Route::get('/resolution/{parameter}', [ResolutionFrontendController::class, 'resolveResolution'])->name('resolution');

Route::get('/council/{councilId}/resolution/{parameter}', [ResolutionFrontendController::class, 'resolveResolutionWithCouncil']);


Route::get('/category/{id}', function ($id) {
    return view('page.category', [
        'category' => Category::findOrFail($id)->load('resolutions')
    ]);
});

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
    Route::get('/resolutions/create', ResolutionsCreate::class)->name('admin.resolutions.create');
    Route::get('/resolutions/{id}', ResolutionsEdit::class)->name('admin.resolutions.edit');


    Route::get('/categories', CategoriesIndex::class)->name('admin.categories.index');

    Route::get('/applicants', ApplicantsIndex::class)->name('admin.applicants.index');
});
