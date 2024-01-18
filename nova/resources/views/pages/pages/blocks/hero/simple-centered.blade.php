<div
    @class([
        'nv-hero nv-hero-simple-centered overflow-hidden font-[family-name:--font-body]',
        'nv-hero-simple-centered-light bg-[--bg-light]' => ! $dark,
        'nv-hero-simple-centered-dark bg-[--bg-dark]' => $dark,
    ])
    style="--color1: {{ $color1 }}; --color2: {{ $color2 }}"
>
    <div class="nv-hero-ctn relative isolate pt-14">
        <div
            class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
            aria-hidden="true"
        >
            <div
                @class([
                    'relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[--color1] to-[--color2] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]',
                    'opacity-30' => ! $dark,
                    'opacity-20' => $dark,
                ])
                style="
                    clip-path: polygon(
                        74.1% 44.1%,
                        100% 61.6%,
                        97.5% 26.9%,
                        85.5% 0.1%,
                        80.7% 2%,
                        72.5% 32.5%,
                        60.2% 62.4%,
                        52.4% 68.1%,
                        47.5% 58.3%,
                        45.2% 34.5%,
                        27.5% 76.7%,
                        0.1% 64.9%,
                        17.9% 100%,
                        27.6% 76.8%,
                        76.1% 97.7%,
                        74.1% 44.1%
                    );
                "
            ></div>
        </div>

        <div class="nv-hero-content-outer py-24 sm:py-32 lg:pb-40">
            <div class="nv-hero-content-inner mx-auto max-w-7xl px-6 lg:px-8">
                <div class="nv-hero-content mx-auto max-w-2xl text-center">
                    @if (filled($calloutText))
                        <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                            <div
                                @class([
                                    'relative rounded-full px-3 py-1 text-sm leading-6 ring-1',
                                    'text-gray-600 ring-gray-900/10 hover:ring-gray-900/20' => ! $dark,
                                    'text-gray-400 ring-white/10 hover:ring-white/20' => $dark,
                                ])
                            >
                                {{ $calloutText }}

                                @if (filled($calloutLinkLabel) && filled($calloutLinkUrl))
                                    <a
                                        href="{{ $calloutLinkUrl ?? '#' }}"
                                        @class([
                                            'font-semibold',
                                            'text-primary-600' => ! $dark,
                                            'text-white' => $dark,
                                        ])
                                    >
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ $calloutLinkLabel }}
                                        <span aria-hidden="true">&rarr;</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if (filled($heading))
                        <h1
                            @class([
                                'nv-hero-heading font-[family-name:--font-header] text-4xl font-bold tracking-tight sm:text-6xl',
                                'text-gray-900' => ! $dark,
                                'text-white' => $dark,
                            ])
                        >
                            {{ $heading }}
                        </h1>
                    @endif

                    @if (filled($description))
                        <p
                            @class([
                                'nv-hero-description text-lg leading-8',
                                'text-gray-600' => ! $dark,
                                'text-gray-300' => $dark,
                                'mt-6' => filled($heading),
                            ])
                        >
                            {{ $description }}
                        </p>
                    @endif

                    @if (filled($primaryButtonLabel) || filled($secondaryButtonLabel))
                        <div
                            @class([
                                'nv-hero-buttons flex items-center justify-center gap-x-6',
                                'mt-10' => filled($heading) || filled($description),
                            ])
                        >
                            @if (filled($primaryButtonLabel) && filled($primaryButtonUrl))
                                <a
                                    href="{{ $primaryButtonUrl }}"
                                    @class([
                                        'nv-btn-primary rounded-md px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2',
                                        'bg-primary-600 hover:bg-primary-500 focus-visible:outline-primary-600' => ! $dark,
                                        'bg-primary-500 hover:bg-primary-400 focus-visible:outline-primary-400' => $dark,
                                    ])
                                >
                                    {{ $primaryButtonLabel }}
                                </a>
                            @endif

                            @if (filled($secondaryButtonLabel) && $secondaryButtonUrl)
                                <a
                                    href="{{ $secondaryButtonUrl }}"
                                    @class([
                                        'nv-btn-secondary text-sm font-semibold leading-6',
                                        'text-gray-900' => ! $dark,
                                        'text-white' => $dark,
                                    ])
                                >
                                    {{ $secondaryButtonLabel }}
                                    <span aria-hidden="true">→</span>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="nv-hero-image mt-16 flow-root sm:mt-24">
                    <img
                        src="https://tailwindui.com/img/component-images/project-app-screenshot.png"
                        alt="App screenshot"
                        width="2432"
                        height="1442"
                        @class([
                            'rounded-xl shadow-2xl ring-1',
                            'ring-gray-900/10' => ! $dark,
                            'bg-white/5 ring-white/10' => $dark,
                        ])
                        class="rounded-xl shadow-2xl ring-1 ring-gray-900/10"
                    />
                </div>
            </div>
        </div>

        <div
            class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
            aria-hidden="true"
        >
            <div
                @class([
                    'relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[--color1] to-[--color2] sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]',
                    'opacity-30' => ! $dark,
                    'opacity-20' => $dark,
                ])
                style="
                    clip-path: polygon(
                        74.1% 44.1%,
                        100% 61.6%,
                        97.5% 26.9%,
                        85.5% 0.1%,
                        80.7% 2%,
                        72.5% 32.5%,
                        60.2% 62.4%,
                        52.4% 68.1%,
                        47.5% 58.3%,
                        45.2% 34.5%,
                        27.5% 76.7%,
                        0.1% 64.9%,
                        17.9% 100%,
                        27.6% 76.8%,
                        76.1% 97.7%,
                        74.1% 44.1%
                    );
                "
            ></div>
        </div>
    </div>
</div>
