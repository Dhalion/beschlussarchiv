<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Beschlusswiki Administration">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{ $head ?? '' }}

    @stack('head')

    <title>{{ $title ?? 'Beschlusswiki Admin' }}</title>
</head>

<body>
    <div>
        <header>
            @yield('header')
        </header>

        <aside class="aside">
            @yield('aside')
            <div>
                <span>
                    {{ Auth::user()->name }} ({{ Auth::user()->email }})
                </span>
                <a href="{{ route('logout') }}" wire:click.prevent="logout">Logout</a>
            </div>

            <nav>
                <select id="council-select" wire:model="council_id" wire:change="changeCouncil">
                    @foreach ($councils as $council)
                        <option value="{{ $council->id }}">{{ $council->name }}</option>
                    @endforeach
                </select>
                <ul>
                    <li><a href="{{ route('admin.dashboard') }}" wire:navigate.hover>Dashboard</a></li>
                    <li><a href="{{ route('admin.resolutions.index') }}" wire:navigate>Beschlüsse</a></li>
                    <li><a href="{{ route('admin.categories.index') }}" wire:navigate>Kategorien</a></li>
                    <li><a href="{{ route('admin.applicants.index') }}" wire:navigate>Antragsteller*innen</a></li>
                    @can('viewAny', App\Models\Council::class)
                        <li><a href="{{ route('admin.councils.index') }}" wire:navigate>Gremien</a></li>
                    @endcan
                </ul>
                @yield('nav')

            </nav>
        </aside>

        <div class="content">
            {{ $slot }}
        </div>
        <footer>

        </footer>
    </div>


    @stack('scripts')
</body>

</html>
