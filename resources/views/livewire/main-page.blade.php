<div>
    <div id="main-content" class="sm:w-full lg:w-3/4 mx-auto">
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
            @if (count($resolutions) > 0)
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

        @if (count($resolutions) == 0)
            <div id="categories">
                <h3>Categories</h3>
                <div id="categories-content"
                    class="h-full text-black mx-5 items-center grid gap-6 grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
                    @foreach ($categories as $category)
                        @php
                            /** @var App\Models\Category $category */
                        @endphp
                        @include('components.category-card', ['category' => $category])
                    @endforeach
                </div>

            </div>
        @endif
    </div>
</div>
