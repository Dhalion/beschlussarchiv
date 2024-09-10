<div class="p-4">
    <h2 class="text-2xl font-bold">Kategorien</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="pt-7">
        <div id="listing-heading" class="pb-5 flex flex-row justify-between">
            <x-input type="text" icon="o-magnifying-glass" class="input-sm" wire:model.live="search" placeholder="Suche"
                id="search" />
            <x-button wire:click="showCreateModal = true" class="btn-primary btn-sm text-white">Neue Kategorie
                anlegen</x-button>
        </div>
        <x-table :headers="$headers" :rows="$categories" :sort-by="$sortBy" with-pagination per-page="perPage">
            @scope('cell_name', $category)
                <a href="{{ route('frontend.category', $category->id) }}" wire:navigate>
                    {{ $category->name }}
                </a>
            @endscope
            @scope('cell_actions', $category)
                <div class="flex flex-row">
                    <x-button icon="o-pencil" class="btn-ghost btn-xs" wire:click="openEditModal('{{ $category->id }}')" />
                    <x-button icon="o-trash" class="btn-ghost btn-xs" wire:click="initDeletion('{{ $category->id }}')" />
                </div>
            @endscope
        </x-table>
    </div>

    {{-- Create category Modal --}}
    <x-modal wire:model="showCreateModal" wire:click.away="{{ $showCreateModal = false }}" title="Kategorie anlegen"
        subtitle="Für Gremium: {{ $this->getCouncilName() }}" class="backdrop-blur">

        <div class="p-4 flex flex-col gap-y-2">
            <x-input type="text" label="Name" wire:model="name" />
            <x-input type="text" label="Tag" wire:model="tag" />
        </div>

        <x-slot:actions>
            <x-button wire:click="$set('showCreateModal', false)" class="btn-outline">Abbrechen</x-button>
            <x-button wire:click="storeCategory" class="btn-primary" label="Speichern" spinner />
        </x-slot>
    </x-modal>

    {{-- Delete category Modal --}}
    <x-modal wire:model="showDeleteModal" wire:click.away="$set('showDeleteModal', false)" title="Kategorie löschen"
        subtitle="Sind Sie sicher, dass Sie die Kategorie löschen möchten?" class="backdrop-blur">

        @php
            /* @var \App\Models\Category $categoryToDelete */
            $resolutionCount = $categoryToDelete->resolutions_count ?? 0;
        @endphp

        @if ($categoryToDelete && $resolutionCount > 0)
            <span>
                Die Kategorie hat {{ $resolutionCount }} {{ $resolutionCount === 1 ? 'Beschluss' : 'Beschlüsse' }}.
                Sollen diese in eine
                andere Kategorie verschoben werden?
                <x-select wire:model="categoryToMoveResolutionsTo" :options="$possibleDestinationCategories"
                    placeholder="Beschlüsse nicht verschieben" placeholder-value="{{ null }}"
                    option-label="tagged_name" class="mt-2 select-md">
                </x-select>
            </span>
        @endif

        <x-slot:actions>
            <x-button wire:click="$set('showDeleteModal', false)" class="btn-outline">Abbrechen</x-button>
            @if ($categoryToDelete)
                <x-button wire:click="deleteCategory('{{ $categoryToDelete->id }}')" spinner
                    class="btn-primary">Löschen</x-button>
            @endif
        </x-slot>
    </x-modal>

    {{-- Edit Modal --}}
    @php
        /* @var \App\Models\Category $this->selectedCategory */
    @endphp
    @if ($this->selectedCategory)
        <x-modal wire:model="showEditModal" wire:click.away="$set('showEditModal', false)" title="Kategorie bearbeiten"
            subtitle="{{ $this->selectedCategory->name }}">
            <div class="p-4 flex flex-col gap-y-2">
                <x-input type="text" label="Name" wire:model="name" />
                <x-input type="text" label="Tag" wire:model="tag" class="w-1/3" />
                <x-file wire:model="image" label="Bild" accept="image/png, image/jpeg">
                    <img src="{{ asset($selectedCategory->image) }}" alt="logo" class="w-1/2 mx-auto p-3">
                </x-file>
                <div class="flex flex-row gap-x-2 pt-3">
                    <x-button wire:click="$set('showEditModal', false)" class="btn-outline">Abbrechen</x-button>
                    <x-button wire:click="updateCategory" class="btn-primary" spinner label="Speichern" />
                </div>
            </div>
        </x-modal>
    @endif

    <x-toast />
</div>
