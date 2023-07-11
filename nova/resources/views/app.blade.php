<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="theme-color" content="#0091ff" media="(prefers-color-scheme: light)" />
        <meta name="theme-color" content="#0091ff" media="(prefers-color-scheme: dark)" />
        <title>{{ config('app.name', 'Nova NextGen') }}</title>

        @livewireStyles
        @filamentStyles
        @novaStyles
        @stack('styles')

        @stack('headScripts')
    </head>
    <body
        class="h-full bg-white font-sans text-gray-500 antialiased dark:bg-gray-950 dark:text-gray-400 xl:bg-gray-100 dark:xl:bg-gray-950"
    >
        <div id="nova">
            @yield('layout')
        </div>

        @stack('modal')
        @livewire('livewire-ui-modal')
        @livewire('livewire-ui-spotlight')
        @livewire('notifications')

        @livewireScripts
        @filamentScripts
        @novaScripts
        @stack('scripts')
    </body>
</html>
