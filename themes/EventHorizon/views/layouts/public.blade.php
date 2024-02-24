@extends($meta->structure)

@push('styles')
    <link rel="stylesheet" href="{{ asset('themes/EventHorizon/design/theme.css') }}" />
@endpush

@section('layout')
    <div class="relative flex-none overflow-hidden text-white">
        <div class="relative w-[35%] pl-6 lg:fixed lg:inset-0 lg:flex">
            <div class="absolute inset-0 -z-10 overflow-hidden bg-gray-950 lg:min-w-[32rem]">
                <img
                    src="{{ asset('dist/black-hole-3-vertical.png') }}"
                    alt=""
                    class="absolute right-0 top-1/2 -translate-y-1/2 opacity-35"
                />
                <svg
                    class="absolute -bottom-48 left-[-40%] hidden h-[80rem] w-[180%] lg:-right-40 lg:bottom-auto lg:left-auto lg:top-[-40%] lg:h-[180%] lg:w-[80rem]"
                    aria-hidden="true"
                >
                    <defs>
                        <radialGradient id=":S1:-desktop" cx="100%">
                            <stop offset="0%" stop-color="rgba(56, 189, 248, 0.3)"></stop>
                            <stop offset="53.95%" stop-color="rgba(0, 71, 255, 0.09)"></stop>
                            <stop offset="100%" stop-color="rgba(10, 14, 23, 0)"></stop>
                        </radialGradient>
                        <radialGradient id=":S1:-mobile" cy="100%">
                            <stop offset="0%" stop-color="rgba(56, 189, 248, 0.3)"></stop>
                            <stop offset="53.95%" stop-color="rgba(0, 71, 255, 0.09)"></stop>
                            <stop offset="100%" stop-color="rgba(10, 14, 23, 0)"></stop>
                        </radialGradient>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#:S1:-desktop)" class="hidden lg:block"></rect>
                    <rect width="100%" height="100%" fill="url(#:S1:-mobile)" class="lg:hidden"></rect>
                </svg>
                <div
                    class="absolute inset-x-0 bottom-0 right-0 hidden h-px bg-white mix-blend-overlay lg:left-auto lg:top-0 lg:h-auto lg:w-px"
                ></div>
            </div>

            <div
                class="relative z-10 mx-auto max-w-lg lg:flex lg:w-96 lg:max-w-none lg:flex-col lg:before:flex-1 lg:before:pt-6"
            >
                <div class="pb-16 pt-20 sm:pb-20 sm:pt-32 lg:py-20">
                    <div class="relative">
                        <div>
                            <a href="/">
                                @if (app('nova.settings')->getFirstMedia('logo'))
                                    <div>
                                        <img
                                            src="{{ app('nova.settings')->getFirstMediaUrl('logo') }}"
                                            alt="logo"
                                            class="inline-block h-8 w-auto"
                                        />
                                    </div>
                                @else
                                    <div class="dark">
                                        <x-logos.nova class="inline-block h-8 w-auto"></x-logos.nova>
                                    </div>
                                @endif
                            </a>
                        </div>
                        {{--
                            <h1 class="font-display mt-14 text-4xl/tight font-light text-white">
                            Open-source Git client
                            <span class="text-sky-300">for macOS minimalists</span>
                            </h1>
                            <p class="mt-4 text-sm/6 text-gray-300">
                            Commit is a lightweight Git client you can open from anywhere any time you’re ready to
                            commit your work with a single keyboard shortcut. It’s fast, beautiful, and completely
                            unnecessary.
                            </p>
                        --}}
                        <div class="mt-8 flex flex-col gap-y-2">
                            <a
                                class="group relative isolate flex flex-none items-center gap-x-3 rounded-lg px-3 py-1.5 font-semibold text-white/30 transition-colors hover:text-sky-300"
                                href="#"
                            >
                                <span
                                    class="absolute inset-0 -z-10 scale-75 rounded-lg bg-white/5 opacity-0 transition group-hover:scale-100 group-hover:opacity-100"
                                ></span>
                                <span class="self-baseline text-white">Home</span>
                            </a>
                            <a
                                class="group relative isolate flex flex-none items-center gap-x-3 rounded-lg px-3 py-1.5 font-semibold text-white/30 transition-colors hover:text-sky-300"
                                href="#"
                            >
                                <span
                                    class="absolute inset-0 -z-10 scale-75 rounded-lg bg-white/5 opacity-0 transition group-hover:scale-100 group-hover:opacity-100"
                                ></span>
                                <span class="self-baseline text-white">Stories</span>
                            </a>
                            <a
                                class="group relative isolate flex flex-none items-center gap-x-3 rounded-lg px-3 py-1.5 font-semibold text-white/30 transition-colors hover:text-sky-300"
                                href="/feed.xml"
                            >
                                <span
                                    class="absolute inset-0 -z-10 scale-75 rounded-lg bg-white/5 opacity-0 transition group-hover:scale-100 group-hover:opacity-100"
                                ></span>
                                <span class="self-baseline text-white">Characters</span>
                            </a>
                            <a
                                class="group relative isolate flex flex-none items-center gap-x-3 rounded-lg px-3 py-1.5 font-semibold text-white/30 transition-colors hover:text-sky-300"
                                href="/feed.xml"
                            >
                                <span
                                    class="absolute inset-0 -z-10 scale-75 rounded-lg bg-white/5 opacity-0 transition group-hover:scale-100 group-hover:opacity-100"
                                ></span>
                                <span class="self-baseline text-white">Join</span>
                            </a>
                            <a
                                class="group relative isolate flex flex-none items-center gap-x-3 rounded-lg px-3 py-1.5 font-semibold text-white/30 transition-colors hover:text-sky-300"
                                href="/feed.xml"
                            >
                                <span
                                    class="absolute inset-0 -z-10 scale-75 rounded-lg bg-white/5 opacity-0 transition group-hover:scale-100 group-hover:opacity-100"
                                ></span>
                                <span class="self-baseline text-white">Contact</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-1 items-end justify-center pb-4 lg:justify-start lg:pb-6">
                    <p class="flex items-center gap-x-1 text-[0.8125rem]/6 text-gray-500">
                        Powered by
                        <a
                            class="group relative isolate flex items-center gap-x-2 rounded-lg px-2.5 py-1.5 text-[0.8125rem]/6 font-medium text-white/30 transition-colors hover:text-sky-300"
                            href="https://anodyne-productions.com"
                            target="_blank"
                        >
                            <span
                                class="absolute inset-0 -z-10 scale-75 rounded-lg bg-white/5 opacity-0 transition group-hover:scale-100 group-hover:opacity-100"
                            ></span>
                            <x-logos.nova-grayscale
                                class="h-4 w-auto flex-none text-gray-600 group-hover:text-sky-300"
                            ></x-logos.nova-grayscale>
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="relative ml-[35%] flex-1 overflow-y-scroll px-6 lg:px-12">
            @yield('template')
        </div>
    </div>
@endsection
