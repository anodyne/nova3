<div>
    <div @class([
        'mx-auto max-w-7xl py-24 sm:px-6 sm:py-32 lg:px-8' => ! $fullWidth,
    ])>
        <div
            @class([
                'relative isolate overflow-hidden bg-gray-900 text-center',
                'px-6 py-24 shadow-2xl sm:rounded-3xl sm:px-16' => ! $fullWidth,
                'px-6 py-24 sm:px-6 sm:py-32 lg:px-8' => $fullWidth,
            ])
        >
            @if (filled($heading))
                <h2 class="mx-auto max-w-2xl text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    {{ $heading }}
                </h2>
            @endif

            @if (filled($description))
                <p
                    @class([
                        'mx-auto max-w-xl text-lg leading-8 text-gray-300',
                        'mt-6' => filled($heading),
                    ])
                >
                    {{ $description }}
                </p>
            @endif

            @if (filled($primaryButtonLabel) || filled($secondaryButtonLabel))
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    @if (filled($primaryButtonLabel) && filled($primaryButtonUrl))
                        <a
                            href="{{ $primaryButtonUrl ?? '#' }}"
                            class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                        >
                            {{ $primaryButtonLabel }}
                        </a>
                    @endif

                    @if (filled($secondaryButtonLabel) && filled($secondaryButtonUrl))
                        <a href="{{ $secondaryButtonUrl ?? '#' }}" class="text-sm font-semibold leading-6 text-white">
                            {{ $secondaryButtonLabel }}
                            <span aria-hidden="true">→</span>
                        </a>
                    @endif
                </div>
            @endif

            <svg
                viewBox="0 0 1024 1024"
                class="absolute left-1/2 top-1/2 -z-10 h-[64rem] w-[64rem] -translate-x-1/2 [mask-image:radial-gradient(closest-side,white,transparent)]"
                aria-hidden="true"
            >
                <circle
                    cx="512"
                    cy="512"
                    r="512"
                    fill="url(#827591b1-ce8c-4110-b064-7cb85a0b1217)"
                    fill-opacity="0.7"
                />
                <defs>
                    <radialGradient id="827591b1-ce8c-4110-b064-7cb85a0b1217">
                        <stop stop-color="{{ $darkShade ?? '#7775D6' }}" />
                        <stop offset="1" stop-color="{{ $lightShade ?? '#E935C1' }}" />
                    </radialGradient>
                </defs>
            </svg>
        </div>
    </div>
</div>
