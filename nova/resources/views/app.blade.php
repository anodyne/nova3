<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="theme-color" content="#0091ff" media="(prefers-color-scheme: light)" />
        <meta name="theme-color" content="#0091ff" media="(prefers-color-scheme: dark)" />
        {!! SEO::generate() !!}

        {{ NovaView::renderHook('admin::styles.before') }}

        <x-fonts section="admin" />
        @filamentStyles
        @novaAdminStyles
        @stack('styles')

        {{ NovaView::renderHook('admin::styles.after') }}
        {{ NovaView::renderHook('admin::head-scripts.before') }}

        @stack('headScripts')

        {{ NovaView::renderHook('admin::head-scripts.after') }}
    </head>
    <body
        class="h-full bg-white font-[family-name:--font-body] text-gray-600 antialiased dark:bg-gray-950 dark:text-gray-400 xl:bg-gray-100 dark:xl:bg-gray-950"
        @if (settings('appearance.panda')) data-panda @endif
    >
        {{ NovaView::renderHook('admin::body.start') }}

        <div id="nova">
            {{ NovaView::renderHook('admin::page.start') }}

            @yield('layout')

            {{ NovaView::renderHook('admin::page.end') }}
        </div>

        @stack('modal')
        @livewire('livewire-ui-spotlight')
        @livewire('wire-elements-modal')
        @livewire('notifications')
        @livewire('scribble.renderer')
        @livewire('scribble.modals')

        {{ NovaView::renderHook('admin::scripts.before') }}

        @filamentScripts(withCore: true)
        @novaAdminScripts
        @stack('scripts')

        {{ NovaView::renderHook('admin::scripts.after') }}
        {{ NovaView::renderHook('admin::body.end') }}
    </body>
</html>
