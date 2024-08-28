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
                <x-button href="{{ route('admin.councils.create') }}" label="Neues Gremium anlegen"
                    class="btn-primary btn-sm text-white" wire:navigate />
            @endcan
        </div>

        <x-table :headers="$headers" :rows="$councils" :sort-by="$sortBy" with-pagination per-page="perPage">
            @scope('cell_actions', $council)
                <div class="flex flex-row">
                    @can('update', $council)
                        <x-button disabled icon="o-pencil" class="btn-ghost btn-xs" />
                    @endcan
                    @can('delete', $council)
                        <x-button icon="o-trash" class="btn-ghost btn-xs" wire:click="deleteCouncil('{{ $council->id }}')"
                            wire:confirm="Sind Sie sicher, dass Sie das Gremium löschen möchten?" />
                    @endcan
                </div>
            @endscope
        </x-table>


    </div>
</div>
