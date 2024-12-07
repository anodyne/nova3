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

                                    {{--
                                        <li class="relative isolate flex items-center gap-x-4">
                                        <div class="absolute -bottom-8 left-0 top-0 flex w-8 justify-center">
                                        <div class="w-px bg-gray-300"></div>
                                        </div>
                                        <div
                                        class="relative z-10 flex h-8 w-8 flex-none items-center justify-center bg-gray-100"
                                        >
                                        @if ($e->passes())
                                        <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="size-6 fill-white stroke-success-500"
                                        >
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M9 12l2 2l4 -4" />
                                        </svg>
                                        @else
                                        <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="size-6 fill-white stroke-danger-500"
                                        >
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M10 10l4 4m0 -4l-4 4" />
                                        </svg>
                                        @endif
                                        </div>
                                        <p class="relative z-10 flex-auto py-0.5 text-sm/6 text-gray-500">
                                        <span class="font-medium text-gray-900">Can I run Nova?</span>
                                        </p>
                                        </li>
                                        <li class="relative flex items-center gap-x-4">
                                        <div class="absolute -bottom-8 left-0 top-0 flex w-8 justify-center">
                                        <div class="w-px bg-gray-300"></div>
                                        </div>
                                        <div
                                        class="relative flex h-8 w-8 flex-none items-center justify-center bg-gray-100"
                                        >
                                        <x-icon
                                        size="md"
                                        class="shrink-0 text-gray-400"
                                        name="tabler-database-cog"
                                        ></x-icon>
                                        
                                        <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="size-6 fill-white stroke-success-500"
                                        >
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M9 12l2 2l4 -4" />
                                        </svg>
                                        </div>
                                        <p class="flex-auto py-0.5 text-sm/6 text-gray-500">
                                        <span class="font-medium text-gray-900">Connect to my database</span>
                                        </p>
                                        </li>
                                        <li class="relative flex items-center gap-x-4">
                                        <div class="absolute -bottom-8 left-0 top-0 flex w-8 justify-center">
                                        <div class="w-px bg-gray-300"></div>
                                        </div>
                                        <div
                                        class="relative flex h-8 w-8 flex-none items-center justify-center bg-gray-100"
                                        >
                                        <x-icon
                                        size="md"
                                        class="shrink-0 text-gray-400"
                                        name="tabler-sparkles"
                                        ></x-icon>
                                        <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="size-6 fill-white stroke-success-500"
                                        >
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M9 12l2 2l4 -4" />
                                        </svg>
                                        </div>
                                        <p class="flex-auto py-0.5 text-sm/6 text-gray-500">
                                        <span class="font-medium text-gray-900">Install Nova</span>
                                        </p>
                                        </li>
                                        <li class="relative flex items-center gap-x-4">
                                        <div class="absolute -bottom-8 left-0 top-0 flex w-8 justify-center">
                                        <div class="w-px bg-gray-300"></div>
                                        </div>
                                        <div
                                        class="relative flex h-8 w-8 flex-none items-center justify-center bg-gray-100"
                                        >
                                        <x-icon
                                        size="md"
                                        class="shrink-0 text-primary-500"
                                        name="tabler-database-import"
                                        ></x-icon>
                                        </div>
                                        <p class="flex-auto py-0.5 text-sm/6 text-gray-500">
                                        <span class="font-medium text-gray-900">Migrate my Nova 2 data</span>
                                        </p>
                                        </li>
                                        <li class="relative flex items-center gap-x-4">
                                        <div class="absolute -bottom-8 left-0 top-0 flex w-8 justify-center">
                                        <div class="w-px bg-gray-300"></div>
                                        </div>
                                        
                                        <div
                                        class="relative flex h-8 w-8 flex-none items-center justify-center bg-gray-100"
                                        >
                                        <x-icon
                                        size="md"
                                        class="shrink-0 text-gray-400"
                                        name="tabler-user-circle"
                                        ></x-icon>
                                        </div>
                                        <p class="flex-auto py-0.5 text-sm/6 text-gray-500">
                                        <span class="font-medium text-gray-900">Setup my account</span>
                                        </p>
                                        </li>
                                    --}}
                                </ul>

                                {{--
                                    <a
                                    href="{{ url('setup') }}"
                                    @class([
                                    'relative inline-flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium transition',
                                    'text-gray-700 hover:bg-gray-200/60 hover:text-gray-900' => ! request()->is('setup'),
                                    'bg-gradient-to-b from-white to-primary-50 text-primary-600 shadow-md shadow-primary-600/10 ring-1 ring-inset ring-primary-600/20' => request()->is('setup'),
                                    ])
                                    >
                                    <x-icon name="tabler-server-2" size="md" class="mr-2.5 opacity-70"></x-icon>
                                    <span>Can I run Nova?</span>
                                    </a>
                                    <a
                                    href="{{ url('setup/configure-database') }}"
                                    @class([
                                    'relative inline-flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium transition',
                                    'text-gray-700 hover:bg-gray-200/60 hover:text-gray-900' => ! request()->is('setup/configure-database'),
                                    'bg-gradient-to-b from-white to-primary-50 text-primary-600 shadow-md shadow-primary-600/10 ring-1 ring-inset ring-primary-600/20' => request()->is('setup/configure-database'),
                                    ])
                                    >
                                    <x-icon name="tabler-database-cog" size="md" class="mr-2.5 opacity-70"></x-icon>
                                    <span>Connect to your database</span>
                                    </a>
                                    <a
                                    href="{{ url('setup/install') }}"
                                    @class([
                                    'relative inline-flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium transition',
                                    'text-gray-700 hover:bg-gray-200/60 hover:text-gray-900' => ! request()->is('setup/install'),
                                    'bg-gradient-to-b from-white to-primary-50 text-primary-600 shadow-md shadow-primary-600/10 ring-1 ring-inset ring-primary-600/20' => request()->is('setup/install'),
                                    ])
                                    >
                                    <x-icon name="tabler-sparkles" size="md" class="mr-2.5 opacity-70"></x-icon>
                                    <span>Install Nova</span>
                                    </a>
                                    <a
                                    href="{{ url('setup/migrate') }}"
                                    @class([
                                    'relative inline-flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium transition',
                                    'text-gray-700 hover:bg-gray-200/60 hover:text-gray-900' => ! request()->is('setup/migrate*'),
                                    'bg-gradient-to-b from-white to-primary-50 text-primary-600 shadow-md shadow-primary-600/10 ring-1 ring-inset ring-primary-600/20' => request()->is('setup/migrate*'),
                                    ])
                                    >
                                    <x-icon name="tabler-database-import" size="md" class="mr-2.5 opacity-70"></x-icon>
                                    <span>Migrate from Nova 2</span>
                                    </a>
                                    <a
                                    href="{{ url('setup/setup-account') }}"
                                    @class([
                                    'relative inline-flex w-full items-center rounded-lg px-3 py-2 text-sm font-medium transition',
                                    'text-gray-700 hover:bg-gray-200/60 hover:text-gray-900' => ! request()->is('setup/setup-account'),
                                    'bg-gradient-to-b from-white to-primary-50 text-primary-600 shadow-md shadow-primary-600/10 ring-1 ring-inset ring-primary-600/20' => request()->is('setup/setup-account'),
                                    ])
                                    >
                                    <x-icon name="tabler-user-circle" size="md" class="mr-2.5 opacity-70"></x-icon>
                                    <span>Setup your account</span>
                                    </a>
                                --}}
                            </nav>

                            <section class="hidden px-6 pt-8">
                                <h4 class="text-xs/6 font-medium text-gray-500">Progress</h4>

                                <ol role="list" class="mt-4 space-y-6">
                                    <li>
                                        <!-- Complete Step -->
                                        <a href="#" class="group">
                                            <span class="flex items-start">
                                                <span
                                                    class="relative flex size-5 flex-shrink-0 items-center justify-center"
                                                >
                                                    <svg
                                                        class="h-full w-full text-primary-600 group-hover:text-primary-800"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        aria-hidden="true"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </span>
                                                <span
                                                    class="ml-3 text-sm font-medium text-gray-500 group-hover:text-gray-900"
                                                >
                                                    Configure database
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <!-- Current Step -->
                                        <a href="#" class="flex items-start" aria-current="step">
                                            <span
                                                class="relative flex size-5 flex-shrink-0 items-center justify-center"
                                                aria-hidden="true"
                                            >
                                                <span class="absolute size-4 rounded-full bg-primary-200"></span>
                                                <span class="relative block h-2 w-2 rounded-full bg-primary-600"></span>
                                            </span>
                                            <span class="ml-3 text-sm font-medium text-primary-600">Install Nova</span>
                                        </a>
                                    </li>
                                    <li>
                                        <!-- Upcoming Step -->
                                        <a href="#" class="group">
                                            <div class="flex items-start">
                                                <div
                                                    class="relative flex size-5 flex-shrink-0 items-center justify-center"
                                                    aria-hidden="true"
                                                >
                                                    <div
                                                        class="h-2 w-2 rounded-full bg-gray-300 group-hover:bg-gray-400"
                                                    ></div>
                                                </div>
                                                <p
                                                    class="ml-3 text-sm font-medium text-gray-500 group-hover:text-gray-900"
                                                >
                                                    Install genre
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <!-- Upcoming Step -->
                                        <a href="#" class="group">
                                            <div class="flex items-start">
                                                <div
                                                    class="relative flex size-5 flex-shrink-0 items-center justify-center"
                                                    aria-hidden="true"
                                                >
                                                    <div
                                                        class="h-2 w-2 rounded-full bg-gray-300 group-hover:bg-gray-400"
                                                    ></div>
                                                </div>
                                                <p
                                                    class="ml-3 text-sm font-medium text-gray-500 group-hover:text-gray-900"
                                                >
                                                    Create user & character
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                </ol>
                            </section>
                        </div>
                    </div>

                    <div class="px-6">
                        <div class="flex flex-col gap-4">
                            <x-icon name="tabler-lifebuoy" size="lg" class="text-gray-400"></x-icon>
                            <h4 class="text-sm font-medium text-gray-900">Need help?</h4>
                            <p class="text-sm/6 text-gray-600">
                                Check out the install guide or join the Discord server to get help with setting up Nova.
                            </p>
                            <div class="grid grid-cols-2 gap-4">
                                <x-button
                                    href="https://anodyne-productions.com/docs/3.0/installation"
                                    target="_blank"
                                    color="neutral"
                                >
                                    Install guide
                                </x-button>
                                <x-button color="neutral">Join Discord</x-button>
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
