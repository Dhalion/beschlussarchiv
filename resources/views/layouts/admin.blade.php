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
            @livewire('admin.aside-menu')
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
