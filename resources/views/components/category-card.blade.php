@php
    /* @var App\Models\Category $category */
@endphp
<div id="category-card" class="bg-creme-300 rounded-3xl shadow-lg text-center h-full p-4">
    <a href="/category/{{ $category->id }}" wire:navigate.hover="category" class="flex flex-col">
        <img src="{{ asset('images/work-in-progress.png') }}" alt="logo" class="w-1/2 mx-auto p-3">
        <h3 class="font-bold text-xs h-1/4 p-2 mb-4">
            {{ $category->name }}
        </h3>
        <span class="text-gray-500 text-sm font-light h-1/4">
            {{ $category->resolutions_count }} {{ $category->resolutions_count == 1 ? 'resolution' : 'resolutions' }}
        </span>
    </a>
</div>
