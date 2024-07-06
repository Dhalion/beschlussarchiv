<div>
    @php
        /** @var App\Models\Category $category */
    @endphp
    <h2>Kategorie: {{ $category->name }}</h2>
    @foreach ($category->resolutions as $resolution)
        @php
            /** @var App\Models\Resolution $resolution */
        @endphp
        <a href="/resolution/{{ $resolution->id }}" wire:navigate.hover="resolution">
            <h4>
                {{ $resolution->title }}
            </h4>
        </a>
    @endforeach
    <div>

    </div>
</div>
