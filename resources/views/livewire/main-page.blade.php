<div>
    <div id="main-content" class="sm:w-full lg:w-3/4 mx-auto px-5 lg:px-0">
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
                    <x-collapse collapse-plus-minus class="border-none mb-5">
                        <x-slot:heading class="flex flex-row items-center gap-x-2 text-slate-400 text-sm px-1">
                            <span class="text-sm">
                                Erweiterte Suche
                            </span>
                            <x-carbon-search-advanced class="w-4" />
                        </x-slot:heading>

                        <x-slot:content id="advanced-search" class="px-0">
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
                        </x-slot:content>
                    </x-collapse>

                </div>
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
