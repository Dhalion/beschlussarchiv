<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Beschlusswiki höhö">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{ $head ?? '' }}

    @stack('head')

    <title>@yield('title', 'Beschlusswiki')</title>
</head>

<body>
    {{ $slot ?? '' }}

    @yield('content')


    @stack('scripts')
</body>

</html>
