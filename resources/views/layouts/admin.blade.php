<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Beschlussarchiv Administration">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{ $head ?? '' }}

    @stack('head')

    <title>{{ $title ?? 'Beschlussarchiv Admin' }}</title>
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
