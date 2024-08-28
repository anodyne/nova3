<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="theme-color" content="#0091ff" media="(prefers-color-scheme: light)" />
        <meta name="theme-color" content="#0091ff" media="(prefers-color-scheme: dark)" />
        {!! SEO::generate(true) !!}

        {{ NovaView::renderHook('public::styles.before') }}

        <x-fonts section="public" />
        @filamentStyles
        @novaPublicStyles
        @stack('styles')

        {{ NovaView::renderHook('public::styles.after') }}
        {{ NovaView::renderHook('public::head-scripts.before') }}

        @stack('headScripts')

        {{ NovaView::renderHook('public::head-scripts.after') }}
    </head>
    <body class="h-full font-[family-name:--font-body] antialiased">
        {{ NovaView::renderHook('public::body.start') }}

        <main id="nova">
            {{ NovaView::renderHook('public::page.start') }}

            @yield('layout')

            {{ NovaView::renderHook('public::page.end') }}
        </main>

        {{ NovaView::renderHook('public::scripts.before') }}

        @filamentScripts(withCore: true)
        @novaPublicScripts
        @stack('scripts')

        {{ NovaView::renderHook('public::scripts.after') }}
        {{ NovaView::renderHook('public::body.end') }}
    </body>
</html>
