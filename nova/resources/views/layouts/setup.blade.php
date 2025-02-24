@use('Nova\Setup\Enums\SetupType')

@php
    $e = nova()->environment();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="theme-color" content="#0091ff" media="(prefers-color-scheme: light)" />
        <meta name="theme-color" content="#0091ff" media="(prefers-color-scheme: dark)" />
        <title>{{ config('app.name', 'Nova NextGen') }}</title>

        <x-fonts section="admin" />
        @filamentStyles
        @novaAdminStyles
        @stack('styles')
        @stack('headScripts')
    </head>
    <body
        class="h-full bg-white font-[family-name:--font-body] text-gray-600 antialiased xl:bg-gray-100 dark:bg-gray-950 dark:text-gray-400 dark:xl:bg-gray-950"
    >
        <div id="nova">
            <div class="relative flex min-h-screen flex-col bg-gray-100">
                <aside class="fixed inset-y-0 z-10 flex w-80 flex-col justify-between py-6">
                    <div class="flex flex-col gap-16">
                        <div class="flex shrink-0 items-center px-6">
                            <x-logos.nova class="block h-10 w-auto" />
                        </div>

                        <div class="flex flex-col gap-8 divide-y divide-gray-950/5">
                            <nav class="flex flex-col gap-2 px-3">
                                <ul role="list" class="space-y-6">
                                    @foreach ($type->getSteps()->steps() as $step)
                                        @if ($step->shouldShow())
                                            <li class="relative isolate flex items-center gap-x-4">
                                                @if (! $loop->last)
                                                    <div
                                                        class="absolute -bottom-8 left-0 top-0 flex w-8 justify-center"
                                                    >
                                                        <div class="w-px bg-gray-300"></div>
                                                    </div>
                                                @endif

                                                <div
                                                    class="relative z-10 flex h-8 w-8 flex-none items-center justify-center bg-gray-100"
                                                >
                                                    {{ $step->icon() }}
                                                </div>
                                                <p class="relative z-10 flex-auto py-0.5 text-sm/6 text-gray-500">
                                                    <span
                                                        @class([
                                                            'font-medium',
                                                            'text-gray-500' => ! $step->isCurrent() && ! $step->isComplete(),
                                                            'text-gray-900' => $step->isCurrent() || $step->isComplete(),
                                                        ])
                                                    >
                                                        {{ $step->title() }}
                                                    </span>
                                                </p>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <div class="px-6">
                        <div class="flex flex-col gap-4">
                            <x-icon name="support" size="lg" class="text-gray-400"></x-icon>
                            <h4 class="text-sm font-medium text-gray-900">Need help?</h4>
                            <p class="text-sm/6 text-gray-600">
                                {{ $type->getHelpIntro() }}
                            </p>
                            <div class="grid grid-cols-2 gap-4">
                                {!! $type->getGuideButton() !!}
                                <x-button :href="config('services.anodyne.links.discord')" color="neutral">
                                    Join Discord
                                </x-button>
                            </div>
                        </div>
                    </div>
                </aside>

                <main class="flex flex-1 flex-col pb-2 lg:min-w-0 lg:pl-80 lg:pr-2 lg:pt-2">
                    <div
                        class="relative grow p-6 lg:rounded-lg lg:bg-white lg:p-10 lg:shadow-sm lg:ring-1 lg:ring-gray-950/5 dark:lg:bg-gray-900 dark:lg:ring-white/10"
                    >
                        <div class="relative z-[2] mx-auto max-w-6xl">
                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        </div>

        @filamentScripts(withCore: true)
        @novaSetupScripts
        @stack('scripts')
    </body>
</html>
