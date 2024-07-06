<div>
    <h2>
        Welcome to the main page
    </h2>
    <div id="search" x-data="{ showAdvancedSearch: {{ $advancedSearch ? 'true' : 'false' }} }"> <input type="text" wire:model.live="query"
            placeholder="Beschluss suchen">
        <button x-on:click="showAdvancedSearch = !showAdvancedSearch">
            Erweiterte Suche
        </button>
        <div id="advanced-search" x-show="showAdvancedSearch">
            <input type="number" wire:model.live="startYear" placeholder="Startjahr">
            <input type="number" wire:model.live="endYear" placeholder="Endjahr">
            <select wire:model.live="categoryId" placeholder="Kategorie">
                <option value="">Kategorie</option>
                @foreach ($categories as $category)
                    @php
                        /** @var App\Models\Category $category */
                    @endphp
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <select wire:model.live="councilId" placeholder="Gremium">
                <option value="">Gremium</option>
                @foreach ($councils as $council)
                    @php
                        /** @var App\Models\Council $council */
                    @endphp
                    <option value="{{ $council->id }}">
                        {{ $council->name }}
                    </option>
                @endforeach
            </select>

        </div>
        @if (!empty($resolutions))
            <h3>
                Suchergebnisse für "{{ $query }}"
            </h3>

            <div class="search-results">
                @foreach ($resolutions as $resolution)
                    @php
                        /** @var App\Models\Resolution $resolution */
                    @endphp
                    <a href="resolution/{{ $resolution->id }}" class="resolution" wire:navigate.hover="resolution">
                        <pre>
                        {{ "[$resolution->year-$resolution->tag]" }} {{ $resolution->title }}
                    </pre>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    @if (empty($resolutions))
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
    @endif
</div>
