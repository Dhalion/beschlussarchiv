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

<body class="flex">
    <header>
        @yield('header')
    </header>

    <aside class="aside w-1/5 h-screen bg-primary-content flex flex-col sticky top-0">
        <div class="bg-jusorot-400 p-3 w-full h-fit">
            <h1 class="text-2xl font-bold text-start text-white">Beschlussarchiv</h1>
            <h2 class="text-base font-bold text-start text-white ">Administration</h2>
        </div>
        <div class="flex-grow">
            @livewire('admin.aside-menu')
        </div>
    </aside>

    <div class="content flex-grow">
        {{ $slot }}
    </div>
    <footer>

    </footer>
</body>

@stack('scripts')

</html>
