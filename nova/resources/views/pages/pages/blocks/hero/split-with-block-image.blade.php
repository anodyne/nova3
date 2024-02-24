@use('Illuminate\Support\Arr')

<div
    @class([
        '@container',
        'nv-hero nv-hero-split-with-image',
        'dark' => $dark,
    ])
    style="--bgColor: {{ $backgroundColor ?? 'transparent' }}"
>
    <x-public::block.wrapper
        :background-type="$backgroundType"
        :background-image-intensity="$backgroundImageIntensity ?? null"
    >
        <div class="nv-ctn @xs:px-6 @xl:px-8 @xs:py-24 @xl:py-32 relative z-10 mx-auto max-w-7xl">
            <div
                class="nv-hero-ctn @xs:mx-auto @xs:grid-cols-1 @xs:gap-y-16 @md:gap-y-20 @xl:mx-0 @xl:max-w-none @xs:max-w-2xl grid gap-x-8 @4xl:grid-cols-2"
            >
                <div
                    @class([
                        'nv-hero-content-wrapper',
                        '@xl:mr-auto @xl:pr-4 ' => isset($orientation) && $orientation === 'right',
                        '@xl:ml-auto @xl:pl-4' => isset($orientation) && $orientation === 'left',
                    ])
                >
                    <div @class([
                        'nv-hero-content-ctn @xl:max-w-lg',
                    ])>
                        @if (filled($calloutText))
                            <div class="nv-hero-callout-ctn @xs:mt-24 @md:mt-32 @xl:mt-16">
                                <a
                                    href="{{ $calloutUrl ?? '#' }}"
                                    class="nv-hero-callout inline-flex space-x-6 transition"
                                >
                                    <span
                                        class="rounded-full bg-primary-50 px-3 py-1 text-sm/6 font-semibold text-primary-700 ring-1 ring-inset ring-primary-200 hover:bg-primary-100 hover:ring-primary-300 dark:bg-primary-950 dark:text-primary-300 dark:ring-primary-800 dark:hover:bg-primary-900 dark:hover:ring-primary-700"
                                    >
                                        {{ $calloutText }}
                                        <span aria-hidden="true">&rarr;</span>
                                    </span>
                                </a>
                            </div>
                        @endif

                        @if (filled($heading))
                            <h1
                                class="{{
                                    Arr::toCssClasses([
                                        'nv-hero-heading font-[family-name:--font-header] font-bold tracking-tight text-gray-900 @xs:text-4xl @md:text-6xl dark:text-white',
                                        'mt-10' => filled($calloutText),
                                        '@xs:mt-24 @md:mt-32 @xl:mt-16' => blank($calloutText),
                                    ])
                                }}"
                                @class([
                                    'nv-hero-heading font-[family-name:--font-header] font-bold tracking-tight text-gray-900 @xs:text-4xl @md:text-6xl dark:text-white',
                                    'mt-10' => filled($calloutText),
                                    '@xs:mt-24 @md:mt-32 @xl:mt-16' => blank($calloutText),
                                ])
                            >
                                {{ $heading }}
                            </h1>
                        @endif

                        @if (filled($description))
                            <div
                                @class([
                                    'nv-hero-description space-y-6 text-lg/8 text-gray-600 dark:text-gray-300',
                                    'mt-6' => filled($heading),
                                    'mt-10' => filled($calloutText) && blank($heading),
                                    '@xs:mt-24 @md:mt-32 @xl:mt-16' => blank($calloutText) && blank($heading),
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
                                        class="nv-btn-primary w-full rounded-lg bg-primary-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 dark:bg-primary-500 dark:text-white dark:hover:bg-primary-400 dark:focus-visible:outline-primary-400 lg:w-auto"
                                    >
                                        {{ $primaryButtonLabel }}
                                    </a>
                                @endif

                                @if (filled($secondaryButtonUrl) && filled($secondaryButtonLabel))
                                    <a
                                        href="{{ $secondaryButtonUrl }}"
                                        class="nv-btn-secondary text-sm/6 font-semibold text-gray-900 dark:text-white"
                                    >
                                        {{ $secondaryButtonLabel }}
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                @if ($mediaType !== 'none')
                    <div
                        @class([
                            'nv-hero-image-ctn flex items-end',
                            'order-last' => isset($orientation) && $orientation === 'right',
                            'order-first justify-end' => isset($orientation) && $orientation === 'left',
                        ])
                    >
                        @if (isset($image) && filled($image))
                            <img
                                src="{{ asset('media/'.$image) }}"
                                alt=""
                                width="2432"
                                height="1442"
                                class="nv-hero-image w-[76rem] rounded-3xl shadow-2xl ring-1 ring-gray-900/10 dark:bg-white/5 dark:ring-white/10"
                            />
                        @endif

                        @if (isset($video) && filled($video))
                            <x-embed :url="$video"></x-embed>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </x-public::block.wrapper>
</div>
