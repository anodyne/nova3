<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Nova NextGen') }}</title>

    @livewireStyles
    @novaStyles
</head>
<body class="font-sans bg-gray-100 text-gray-900 dark:bg-black dark:text-gray-100 antialiased">
    <div id="app">
        @yield('layout')

        <x-toasts />

        @stack('modal')
        @stack('dropdown')
    </div>

    @livewireScripts
    @novaScripts
    @stack('scripts')
</body>
</html>
