<div>
    <div id="main-content" class="sm:w-full lg:w-3/4 mx-auto px-5 lg:px-0 pb-5">
        <div id="search" x-data="{ showAdvancedSearch: {{ $advancedSearch ? 'true' : 'false' }} }">
            <div id="search-box"
                class="shadow-lg bg-rosa-300 dark:bg-rosa-200 flex
                        justify-center items-center flex-col mt-10 rounded-3xl">
                <h2 class="text-beere-600 dark:text-beere-500 xl:text-5xl text-3xl mt-10 font-bold">
                    Beschlüsse suchen
                </h2>
                <div id="search-inputs" class="flex flex-col mt-8 xl:mt-10 xl:w-1/2 w-10/12">

                    <input type="text" wire:model.live="query" placeholder="Beschluss suchen"
                        class=" bg-white w-full text-black p-3 rounded-xl shadow-xl border-cool-200 border-2 text-sm focus:outline-none hover:ring hover:ring-beere focus:ring focus:ring-beere focus:scale-105 transition-transform hover:scale-105 duration-300 ease-in-out">

                    <x-collapse wire:model="advancedSearch" collapse-plus-minus class="border-none mb-5">
                        <x-slot:heading class="flex flex-row items-center gap-x-2 text-slate-400 text-sm px-1">
                            <span class="text-sm">
                                Erweiterte Suche
                            </span>
                            <x-carbon-search-advanced class="w-4" />
                        </x-slot:heading>

                        <x-slot:content id="advanced-search" class="px-0 grid grid-cols-2 gap-2">
                            <x-input type="number" class="input-sm" wire:model.live="startYear" icon="o-calendar-days"
                                placeholder="Startjahr" />

                            <x-input type="number" class="input-sm" wire:model.live="endYear" icon="o-calendar-days"
                                placeholder="Endjahr" />

                            <x-select class="select-sm" wire:model.live="categoryId" :options="$categories"
                                option-label="tagged_name" placeholder="Kategorie" />

                            <x-select class="select-sm" wire:model.live="councilId" :options="$councils"
                                placeholder="Gremium" />

                        </x-slot:content>
                    </x-collapse>

                </div>
            </div>

            @if ($searching && $totalResults === 0)
                <span class="text-slate-400 text-xs mt-3 pt-5">
                    Keine Suchergebnisse für "{{ $query }}"
                </span>
            @endif
            @if ($searching && $totalResults > 0)
                <span class="text-slate-400 text-xs mt-3 pt-5">
                    Suchergebnisse für "{{ $query }}". {{ $totalResults }} Ergebnisse in {{ $searchTotalTime }}ms
                    gefunden.
                </span>

                <div class="search-results flex flex-col gap-y-3 pt-6">
                    @foreach ($resolutions as $resolution)
                        @php
                            /** @var App\Models\Resolution $resolution */
                        @endphp
                        @include('components.resolution-card', ['resolution' => $resolution])
                    @endforeach
                </div>
            @endif
        </div>

        @if (!$searching)
            <div id="categories"
                class="h-full text-black mt-10 items-center grid gap-6 grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
                @foreach ($categories as $category)
                    @php
                        /** @var App\Models\Category $category */
                    @endphp
                    @include('components.category-card', ['category' => $category])
                @endforeach

            </div>
        @endif
    </div>
</div>
