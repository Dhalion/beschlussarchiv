<div class="p-4">
    <h2 class="text-2xl font-bold">Gremien</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="pt-7">
        <div id="listing-heading" class="pb-5 flex flex-row justify-between">
            <x-input type="text" icon="o-magnifying-glass" class="input-sm" wire:model.live="search" placeholder="Suche"
                id="search" />
            @can('create', App\Models\Council::class)
                <x-button label="Neues Gremium anlegen" class="btn-primary btn-sm text-white"
                    wire:click="$set('showCreateModal', true)" />
            @endcan
        </div>

        <x-table :headers="$headers" :rows="$councils" :sort-by="$sortBy" with-pagination per-page="perPage">
            @scope('cell_actions', $council)
                <div class="flex flex-row">
                    @can('update', $council)
                        <x-button disabled icon="o-pencil" class="btn-ghost btn-xs" />
                    @endcan
                    @can('delete', $council)
                        <x-button icon="o-trash" class="btn-ghost btn-xs" wire:click="openDeleteModal('{{ $council->id }}')" />
                    @endcan
                </div>
            @endscope
        </x-table>
    </div>

    {{-- Create Council Modal --}}
    <x-modal title="Gremium anlegen" wire:model="showCreateModal">
        <div>
            <x-input type="text" label="Name" wire:model="name" />
            <x-input type="text" label="Kürzel" wire:model="shortName" />
        </div>
        <x-slot:actions>
            <x-button wire:click="$set('showCreateModal', false)" class="btn-outline" label="Abbrechen" />
            <x-button wire:click="createCouncil" class="btn-primary" label="Gremium anlegen" spinner />
        </x-slot:actions>
    </x-modal>

    {{-- Delete Council Modal --}}
    <x-modal title="Gremium löschen" wire:model="showDeleteModal">
        @if ($councilToDelete)
            <div>
                <p>Bist du sicher, dass du das Gremium <strong>{{ $councilToDelete->name }}</strong> löschen möchtest?
                </p>
                <p>
                    @if ($councilToDelete->categories_count > 0)
                        Das Gremium hat {{ $councilToDelete->categories_count }}
                        {{ $councilToDelete->categories_count === 1 ? 'Kategorie' : 'Kategorien' }}.
                    @endif
                    @if ($councilToDelete->resolutions_count > 0)
                        Das Gremium hat {{ $councilToDelete->resolutions_count }}
                        {{ $councilToDelete->resolutions_count === 1 ? 'Beschluss' : 'Beschlüsse' }}.
                    @endif
                </p>
            </div>
        @endif
        <x-slot:actions>
            <x-button wire:click="$set('showDeleteModal', false)" class="btn-outline" label="Abbrechen" />
            <x-button wire:click="deleteCouncil" class="btn-primary" label="Gremium löschen" spinner />
        </x-slot:actions>
    </x-modal>


    <x-toast />
</div>
