<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\MainPage;
use App\Models\Category;
use App\Models\Resolution;

Route::get('/', MainPage::class);

Route::get('/resolution/{id}', function ($id) {
    return view('page.resolution', [
        'resolution' => Resolution::findOrFail($id)
    ]);
});

Route::get('/category/{id}', function ($id) {
    return view('page.category', [
        'category' => Category::findOrFail($id)->load('resolutions')
    ]);
});
