@php
    /* @var App\Models\Category $category */
@endphp
<div class="category-card">
    <a href="/category/{{ $category->id }}" wire:navigate.hover="category">
        <img src="{{ asset('images/work-in-progress.png') }}" alt="logo" width="50px">
        <h3>
            {{ $category->name }}
        </h3>
        <span>
            @php
                $resolutionsCount = $category->resolutions->count();
            @endphp
            {{ $resolutionsCount }} {{ $resolutionsCount == 1 ? 'resolution' : 'resolutions' }}
        </span>
    </a>
</div>
