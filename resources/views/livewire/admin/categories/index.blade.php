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
            <x-button wire:click="createCategory" class="btn-primary btn-sm text-white">Neue Kategorie
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
                    <x-button icon="o-pencil" class="btn-ghost btn-xs" disabled />
                    <x-button icon="o-trash" class="btn-ghost btn-xs" wire:click="deleteCategory('{{ $category->id }}')"
                        wire:confirm="Sind Sie sicher, dass Sie die Kategorie löschen möchten?" />
                </div>
            @endscope
        </x-table>
    </div>
</div>
