<div class="p-4 flex flex-col justify-center">
    <div class="flex flex-row items-center gap-x-4">
        <h2 class="text-2xl font-bold">Beschlüsse</h2>
        <x-button icon="o-arrow-path" wire:click="$refresh" class="btn-ghost btn-xs w-7 h-7" />
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-center min-h-screen min-w-screen" wire:loading.flex>
        <x-loading class="text-primary loading-lg self-center mt-10" />
    </div>

    <div class="pt-7" wire:loading.class="hidden">
        <div id="listing-heading" class="pb-5 flex flex-row justify-between">
            <x-input type="text" icon="o-magnifying-glass" class="input-sm" wire:model.live="search"
                placeholder="Suche" id="search" />
            <x-button class="btn-primary btn-sm text-white " icon="o-plus"
                href="{{ route('admin.resolutions.create') }}" wire:navigate>Neuen Beschluss anlegen</x-button>
        </div>

        <x-table :headers="$headers" :rows="$resolutions" :sort-by="$sortBy" with-pagination per-page="perPage">
            @scope('cell_applicants', $resolution)
                @foreach ($resolution->applicants as $applicant)
                    <a href="{{ route('admin.applicants.index', $applicant) }}" wire:navigate>
                        {{ $applicant->name }}
                        @if (!$loop->last)
                            &comma;
                        @endif
                    </a>
                @endforeach
                @if ($resolution->applicants->count() === 0)
                    <span>Keine Antragsteller*innen</span>
                @endif
            @endscope

            @scope('cell_tag', $resolution)
                <x-badge value="{{ $resolution->tag }}" class="border-none p-3 text-center"
                    style="background-color: {{ $this->getColorFromTag($resolution->tag) }}" />
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
