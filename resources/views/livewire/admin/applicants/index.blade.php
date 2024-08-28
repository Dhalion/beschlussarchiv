<div class="p-4">
    <h2 class="text-2xl font-bold">Antragsteller*innen</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="pt-7">
        <div id="listing-heading" class="pb-5 flex flex-row justify-between">
            <x-input type="text" icon="o-magnifying-glass" class="input-sm" wire:model.live="search" placeholder="Suche"
                id="search" />
            <x-button wire:click="" label="Neue*n Antragsteller*in anlegen" class="btn-primary btn-sm text-white" />
        </div>
        <x-table :headers="$headers" :rows="$applicants" :sort-by="$sortBy" with-pagination per-page="perPage">
            @scope('cell_name', $applicant)
                <a href="{{ route('admin.applicants.index', $applicant->id) }}" wire:navigate>
                    {{ $applicant->name }}
                </a>
            @endscope
            @scope('cell_actions', $applicant)
                <div class="flex flex-row">
                    <x-button icon="o-pencil" class="btn-ghost btn-xs" disabled />
                    <x-button icon="o-trash" class="btn-ghost btn-xs" wire:click="deleteApplicant('{{ $applicant->id }}')"
                        wire:confirm="Sind Sie sicher, dass Sie die*n Antragsteller*in löschen möchten?" />
                </div>
            @endscope
        </x-table>
    </div>

</div>
