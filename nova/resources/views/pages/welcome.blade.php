<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Nova NextGen</title>

        <x-fonts section="public" />

        @livewireStyles
        @filamentStyles
        @novaPublicStyles
    </head>
    <body class="bg-white font-(family-name:--font-body) leading-normal text-gray-600">
        <div class="bg-white">
            <div class="from-primary-100/20 relative isolate overflow-hidden bg-gradient-to-b">
                <div class="mx-auto max-w-7xl pt-10 pb-24 sm:pb-32 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:px-8 lg:py-40">
                    <div class="px-6 lg:px-0 lg:pt-4">
                        <div class="mx-auto max-w-2xl">
                            <div class="max-w-lg">
                                <x-logos.nova class="h-12" />
                                {{--
                                    <div class="mt-24 sm:mt-32 lg:mt-16">
                                    <a href="#" class="inline-flex space-x-6">
                                    <span
                                    class="rounded-full bg-primary-600/10 px-3 py-1 text-sm font-semibold leading-6 text-primary-600 ring-1 ring-inset ring-primary-600/10"
                                    >
                                    What's new
                                    </span>
                                    <span
                                    class="inline-flex items-center space-x-2 text-sm font-medium leading-6 text-gray-600"
                                    >
                                    <span>Just shipped v0.1.0</span>
                                    <svg
                                    class="size-5 text-gray-400"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    aria-hidden="true"
                                    >
                                    <path
                                    fill-rule="evenodd"
                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                    clip-rule="evenodd"
                                    />
                                    </svg>
                                    </span>
                                    </a>
                                    </div>
                                --}}
                                <h1
                                    class="mt-24 font-(family-name:--font-header) text-4xl font-bold tracking-tight text-gray-900 sm:mt-32 sm:text-6xl lg:mt-16"
                                >
                                    Welcome to the next generation
                                </h1>
                                <p class="mt-6 text-lg leading-8 text-gray-600">
                                    Re-written from the ground up, Nova 3 is the culmination of years of re-thinking the
                                    way stories can be told and RPGs should be managed. Say hello to the next
                                    generation.
                                </p>
                                <div class="mt-10 flex items-center gap-x-8">
                                    @if (nova()->isInstalled())
                                        <a
                                            href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}"
                                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700"
                                        >
                                            @guest
                                                Sign in
                                            @else
                                                Dashboard
                                            @endguest
                                            <span aria-hidden="true"><span aria-hidden="true">→</span></span>
                                        </a>
                                    @else
                                        <a
                                            href="{{ url('setup') }}"
                                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700"
                                        >
                                            Install
                                            <span aria-hidden="true"><span aria-hidden="true">→</span></span>
                                        </a>
                                    @endif
                                    <a
                                        href="https://anodyne-productions.com/docs/3.0"
                                        class="hover:text-primary-600 text-sm leading-6 font-semibold text-gray-900"
                                    >
                                        Documentation
                                    </a>
                                    <a
                                        href="https://discord.gg/7WmKUks"
                                        class="hover:text-primary-600 text-sm leading-6 font-semibold text-gray-900"
                                    >
                                        Discuss on Discord
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-20 sm:mt-24 md:mx-auto md:max-w-2xl lg:mx-0 lg:mt-0 lg:w-screen">
                        <div
                            class="shadow-primary-600/10 ring-primary-50 absolute inset-y-0 right-1/2 -z-10 -mr-10 w-[200%] skew-x-[-30deg] bg-white shadow-xl ring-1 md:-mr-20 lg:-mr-36"
                            aria-hidden="true"
                        ></div>
                        <div class="shadow-lg md:rounded-3xl">
                            <div
                                class="bg-primary-500 [clip-path:inset(0)] md:[clip-path:inset(0_round_theme(borderRadius.3xl))]"
                            >
                                <div
                                    class="bg-primary-100 absolute -inset-y-px left-1/2 -z-10 ml-10 w-[200%] skew-x-[-30deg] opacity-20 ring-1 ring-white ring-inset md:ml-20 lg:ml-36"
                                    aria-hidden="true"
                                ></div>
                                <div class="relative px-6 pt-8 sm:pt-16 md:pr-0 md:pl-16">
                                    <div class="mx-auto max-w-2xl md:mx-0 md:max-w-none">
                                        <div class="w-screen overflow-hidden rounded-tl-xl bg-gray-900">
                                            <div class="flex bg-gray-800/40 ring-1 ring-white/5">
                                                <div class="-mb-px flex text-sm leading-6 font-medium text-gray-400">
                                                    <div
                                                        class="border-r border-b border-r-white/10 border-b-white/20 bg-white/5 px-4 py-2 text-white"
                                                    >
                                                        NotificationSetting.jsx
                                                    </div>
                                                    <div class="border-r border-gray-600/10 px-4 py-2">App.jsx</div>
                                                </div>
                                            </div>
                                            <div class="px-6 pt-6 pb-14">
                                                <!-- Your code example -->
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="pointer-events-none absolute inset-0 ring-1 ring-black/10 ring-inset md:rounded-3xl"
                                        aria-hidden="true"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-x-0 bottom-0 -z-10 h-24 bg-gradient-to-t from-white sm:h-32"></div>
            </div>
        </div>

        @livewire('notifications')

        @filamentScripts(withCore: true)
        @novaPublicScripts
        @stack('scripts')
    </body>
</html>
