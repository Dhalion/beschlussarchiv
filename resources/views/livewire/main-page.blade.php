<div>
    <h2>
        Welcome to the main page
    </h2>
    <div id="search">
        <input type="text" wire:model.live="search" placeholder="Beschluss suchen">
    </div>
    <h3>
        Suchergebnisse für "{{ $search }}"
    </h3>
    <pre>
        {{ $resolutions }}
    </pre>
    <div id="categories">
        <h3>Categories</h3>
        @foreach ($categories as $category)
            @php
                /** @var App\Models\Category $category */
            @endphp
            <div>
                <h3>
                    {{ $category->name }}
                </h3>
                <span>
                    {{ $category->id }}
                </span>
            </div>
        @endforeach

    </div>
</div>
