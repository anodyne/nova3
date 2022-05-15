<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0091ff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0091ff" media="(prefers-color-scheme: dark)">
    <title>{{ config('app.name', 'Nova NextGen') }}</title>

    @livewireStyles
    @bukStyles
    @novaStyles
    @stack('styles')

    @novaScripts
    @stack('headScripts')
</head>
<body class="font-sans antialiased text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-900">
    <div id="nova">
        @yield('layout')

        <x-toasts />
    </div>

    @stack('modal')
    @livewire('livewire-ui-modal')
    @livewire('livewire-ui-spotlight')

    @livewireScripts
    @bukScripts
    @stack('scripts')
</body>
</html>
