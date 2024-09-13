<div class="flex flex-col px-5 h-full">
    <nav class="navigation flex flex-col justify-between h-full">
        <div class="pt-2">
            <label for="council-select" class="text-xs">Gremium</label>
            <x-select id="council-select" wire:model="councilId" wire:change="updateCouncilId" :options="$councils"
                placeholder="Gremium wählen" class="select-xs label-sm select-bordered">
            </x-select>

            <x-menu class="text-base p-0 pt-3">
                <x-menu-item title="Dashboard" icon="o-home" wire:navigate.hover
                    href="{{ route('admin.dashboard') }}" />
                <x-menu-item title="Beschlüsse" icon="o-document-duplicate" wire:navigate.hover
                    href="{{ route('admin.resolutions.index') }}" />
                <x-menu-item title="Kategorien" icon="o-folder" wire:navigate.hover
                    href="{{ route('admin.categories.index') }}" />
                <x-menu-item title="Antragsteller*innen" icon="o-users" wire:navigate.hover
                    href="{{ route('admin.applicants.index') }}" />

                @can('viewAny', App\Models\Council::class)
                    <x-menu-item title="Gremien" icon="o-user-group" wire:navigate.hover
                        href="{{ route('admin.councils.index') }}" />
                @endcan
            </x-menu>
            @yield('nav')
        </div>

        <div class="flex flex-col session pb-5">
            <span>
                {{ Auth::user()->name }} ({{ Auth::user()->email }})
            </span>
            <x-button wire:click.prevent="logout" class="btn">Logout</x-button>
        </div>
    </nav>
    <x-toast />
</div>
