<div class="p-4">
    <h2 class="text-2xl font-bold">Beschlüsse</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="pt-7">
        <div id="listing-heading" class="pb-5 flex flex-row justify-between">
            <x-input type="text" icon="o-magnifying-glass" class="input-sm" wire:model.live="search" placeholder="Suche"
                id="search" />
            <x-button class="btn-primary btn-sm text-white " icon="o-plus"
                href="{{ route('admin.resolutions.create') }}" wire:navigate>Neuen Beschluss anlegen</x-button>
        </div>
        <x-table :headers="$headers" :rows="$resolutions" :sort-by="$sortBy" with-pagination per-page="perPage">
            @scope('cell_applicants', $resolution)
                @foreach ($resolution->applicants as $applicant)
                    <a href="{{ route('admin.applicants.show', $applicant) }}" wire:navigate>{{ $applicant->name }}</a>
                @endforeach
                @if ($resolution->applicants->count() === 0)
                    <span>Keine Antragsteller*innen</span>
                @endif
            @endscope


            @scope('cell_actions', $resolution)
                <div class="flex flex-row">
                    <x-button icon="o-pencil" class="btn-ghost btn-xs"
                        href="{{ route('admin.resolutions.edit', $resolution) }}" wire:navigate />
                    <x-button icon="o-trash" class="btn-ghost btn-xs" wire:click="delete({{ $resolution->id }})" />
                    <x-button icon="o-eye" class="btn-ghost btn-xs" href="{{ route('frontend.resolution', $resolution) }}"
                        wire:navigate />
                </div>
            @endscope

        </x-table>
    </div>
</div>
