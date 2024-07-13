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
            <nav>
                <ul>
                    <li><a href="{{ route('admin.dashboard') }}" wire:navigate.hover>Dashboard</a></li>
                    <li><a href="{{ route('admin.resolutions.index') }}" wire:navigate>Beschlüsse</a></li>
                    <li><a href="{{ route('admin.categories.index') }}" wire:navigate>Kategorien</a></li>
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
