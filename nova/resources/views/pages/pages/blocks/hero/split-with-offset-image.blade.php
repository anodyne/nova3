<div
    @class([
        'nv-hero nv-hero-split-with-offset-image relative font-[family-name:--font-body]',
        'nv-hero-split-with-offset-image-light bg-[--bg-light]' => ! $dark,
        'nv-hero-stacked-with-image-dark bg-[--bg-dark]' => $dark,
    ])
>
    <div
        @class([
            'nv-hero-wrapper relative isolate overflow-hidden bg-gradient-to-b pt-14',
            'from-primary-100/20' => ! $dark,
            'from-primary-950/15' => $dark,
        ])
    >
        <div
            @class([
                'absolute inset-y-0 right-1/2 -z-10 -mr-96 w-[200%] origin-top-right skew-x-[-30deg] shadow-xl ring-1 sm:-mr-80 lg:-mr-96',
                'bg-[bg-light] shadow-primary-600/10 ring-primary-200/50' => ! $dark,
                'bg-[--bg-dark] shadow-primary-900/10 ring-primary-900/40' => $dark,
            ])
            class=""
            aria-hidden="true"
        ></div>

        <div class="nv-hero-ctn mx-auto max-w-7xl px-6 py-32 sm:py-40 lg:px-8">
            @if (filled($calloutText))
                <div class="nv-hero-callout-ctn mt-24 sm:mt-32 lg:mt-16">
                    <a href="{{ $calloutUrl ?? '#' }}" class="nv-hero-callout inline-flex space-x-6 transition">
                        <span
                            @class([
                                'rounded-full px-3 py-1 text-sm/6 font-semibold ring-1 ring-inset',
                                'bg-primary-50 text-primary-700 ring-primary-200 hover:bg-primary-100 hover:ring-primary-300' => ! $dark,
                                'bg-primary-950 text-primary-300 ring-primary-800 hover:bg-primary-900 hover:ring-primary-700' => $dark,
                            ])
                        >
                            {{ $calloutText }}
                            <span aria-hidden="true">&rarr;</span>
                        </span>
                    </a>
                </div>
            @endif

            <div
                class="mx-auto max-w-2xl lg:mx-0 lg:grid lg:max-w-none lg:grid-cols-2 lg:gap-x-16 lg:gap-y-6 xl:grid-cols-1 xl:grid-rows-1 xl:gap-x-8"
            >
                @if (filled($heading))
                    <h1
                        @class([
                            'max-w-2xl font-[family-name:--font-header] text-4xl font-bold tracking-tight sm:text-6xl lg:col-span-2 xl:col-auto',
                            'text-gray-900' => ! $dark,
                            'text-white' => $dark,
                        ])
                    >
                        {{ $heading }}
                    </h1>
                @endif

                <div class="mt-6 max-w-xl lg:mt-0 xl:col-end-1 xl:row-start-1">
                    @if (filled($description))
                        <div
                            @class([
                                'space-y-6 text-lg/8',
                                'text-gray-600' => ! $dark,
                                'text-gray-300' => $dark,
                            ])
                        >
                            {!! str($description)->markdown() !!}
                        </div>
                    @endif

                    @if (filled($primaryButtonUrl) || filled($secondaryButtonUrl))
                        <div class="nv-hero-buttons-ctn mt-10 flex flex-col items-center gap-6 lg:flex-row">
                            @if (filled($primaryButtonLabel) && filled($primaryButtonUrl))
                                <a
                                    href="{{ $primaryButtonUrl }}"
                                    @class([
                                        'nv-btn-primary w-full rounded-lg px-3.5 py-2.5 text-center text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 lg:w-auto',
                                        'nv-btn-primary-light bg-primary-600 text-white hover:bg-primary-500 focus-visible:outline-primary-600' => ! $dark,
                                        'nv-btn-primary-dark bg-primary-500 text-white hover:bg-primary-400 focus-visible:outline-primary-400' => $dark,
                                    ])
                                >
                                    {{ $primaryButtonLabel }}
                                </a>
                            @endif

                            @if (filled($secondaryButtonUrl) && filled($secondaryButtonLabel))
                                <a
                                    href="{{ $secondaryButtonUrl }}"
                                    @class([
                                        'nv-btn-secondary text-sm/6 font-semibold',
                                        'nv-btn-secondary-light text-gray-900' => ! $dark,
                                        'nv-btn-secondary-dark text-white' => $dark,
                                    ])
                                >
                                    {{ $secondaryButtonLabel }}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
                <img
                    src="{{ asset('media/'.$image) }}"
                    alt=""
                    class="mt-10 aspect-[6/5] w-full max-w-lg rounded-2xl object-cover sm:mt-16 lg:mt-0 lg:max-w-none xl:row-span-2 xl:row-end-2 xl:mt-36"
                />
            </div>
        </div>
        <div
            @class([
                'absolute inset-x-0 bottom-0 -z-10 h-24 bg-gradient-to-t',
                'from-[--bg-light]' => ! $dark,
                'from-[--bg-dark]' => $dark,
            ])
        ></div>
    </div>
</div>
