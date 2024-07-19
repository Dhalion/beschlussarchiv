<div>

    <div>
        <span>
            {{ Auth::user()->name }} ({{ Auth::user()->email }})
        </span>
        <a href="{{ route('logout') }}" wire:click.prevent="logout">Logout</a>
        <span>Gremium: {{ session('councilId') }}</span>
    </div>

    <nav>
        <select id="council-select" wire:model="councilId" wire:change="updateCouncilId">
            @foreach ($councils as $council)
                <option value="{{ $council->id }}">{{ $council->name }}</option>
            @endforeach
        </select>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}" wire:navigate.hover>Dashboard</a></li>
            <li><a href="{{ route('admin.resolutions.index') }}" wire:navigate>Beschlüsse</a></li>
            <li><a href="{{ route('admin.categories.index') }}" wire:navigate>Kategorien</a>
            </li>
            <li><a href="{{ route('admin.applicants.index') }}" wire:navigate>Antragsteller*innen</a></li>
            @can('viewAny', App\Models\Council::class)
                <li><a href="{{ route('admin.councils.index') }}" wire:navigate>Gremien</a></li>
            @endcan
        </ul>
        @yield('nav')

    </nav>
</div>
