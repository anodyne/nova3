<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="theme-color" content="#0091ff" media="(prefers-color-scheme: light)" />
        <meta name="theme-color" content="#0091ff" media="(prefers-color-scheme: dark)" />
        {!! SEO::generate() !!}

        {{ NovaView::renderHook('auth::styles.before') }}

        <x-fonts section="admin" />
        @filamentStyles
        @novaAdminStyles
        @stack('styles')

        {{ NovaView::renderHook('auth::styles.after') }}
        {{ NovaView::renderHook('auth::head-scripts.before') }}

        @stack('headScripts')

        {{ NovaView::renderHook('auth::head-scripts.after') }}
    </head>
    <body
        class="h-full bg-white font-[family-name:--font-body] text-gray-600 antialiased dark:bg-gray-950 dark:text-gray-400 xl:bg-gray-100 dark:xl:bg-gray-950"
        @if (settings('appearance.panda')) data-panda @endif
    >
        {{ NovaView::renderHook('auth::body.start') }}

        <div id="nova">
            {{ NovaView::renderHook('auth::page.start') }}

            <x-spacing size="xl" class="flex min-h-screen flex-col justify-center">
                <div class="relative z-10 sm:mx-auto sm:w-full sm:max-w-md">
                    @if (app('nova.settings')->getFirstMedia('logo'))
                        <div>
                            <img
                                src="{{ app('nova.settings')->getFirstMediaUrl('logo') }}"
                                alt="logo"
                                class="mx-auto h-12 w-auto"
                            />
                        </div>
                    @else
                        <x-logos.nova class="mx-auto h-12 w-auto" />
                    @endif

                    <x-h1 class="mt-6 text-center">
                        {{ $pageHeader }}
                    </x-h1>
                </div>

                <div class="z-10 mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                    {{ $slot }}
                </div>
            </x-spacing>

            {{ NovaView::renderHook('auth::page.end') }}
        </div>

        @stack('modal')
        @livewire('livewire-ui-spotlight')
        @livewire('wire-elements-modal')
        @livewire('notifications')
        @livewire('scribble.renderer')
        @livewire('scribble.modals')

        {{ NovaView::renderHook('auth::scripts.before') }}

        @filamentScripts(withCore: true)
        @novaAdminScripts
        @stack('scripts')

        {{ NovaView::renderHook('auth::scripts.after') }}
        {{ NovaView::renderHook('auth::body.end') }}
    </body>
</html>
