<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Nova NextGen') }}</title>

    @livewireStyles
    @bukStyles
    @novaStyles
    @stack('styles')

    @novaScripts
</head>
<body class="font-sans bg-gray-2 text-gray-12 antialiased {{ auth()->user()?->appearance ?? 'light' }}">
    <div id="app">
        @yield('layout')

        <x-toasts />
        @stack('modal')
    </div>

    @livewire('livewire-ui-modal')
    @livewire('livewire-ui-spotlight')

    @livewireScripts
    @bukScripts
    @stack('scripts')
</body>
</html>
