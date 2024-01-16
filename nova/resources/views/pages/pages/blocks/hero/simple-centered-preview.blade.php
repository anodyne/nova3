<div class="nv-hero nv-hero-simple-centered bg-[--bg-light]" style="--color1: {{ $color1 }}; --color2: {{ $color2 }}">
    <div class="nv-hero-ctn relative isolate px-6 pt-14 lg:px-8">
        <div class="nv-hero-content mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
            @if (filled($calloutText))
                <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                    <div
                        class="relative rounded-full px-3 py-1 text-sm leading-6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20"
                    >
                        {{ $calloutText }}

                        @if (filled($calloutLinkLabel) && filled($calloutLinkUrl))
                            <a href="{{ $calloutLinkUrl ?? '#' }}" class="font-semibold text-primary-600">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                {{ $calloutLinkLabel }}
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <div class="nv-hero-content-header text-center">
                <h1 class="nv-hero-heading text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                    {{ $heading }}
                </h1>
                <p class="nv-hero-description mt-6 text-lg leading-8 text-gray-600">
                    {{ $description }}
                </p>
                <div class="nv-hero-buttons mt-10 flex items-center justify-center gap-x-6">
                    @if (filled($primaryButtonLabel) && filled($primaryButtonUrl))
                        <a
                            href="{{ $primaryButtonUrl ?? '#' }}"
                            class="nv-btn-primary rounded-md bg-primary-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600"
                        >
                            {{ $primaryButtonLabel }}
                        </a>
                    @endif

                    @if (filled($secondaryButtonLabel) && filled($secondaryButtonUrl))
                        <a
                            href="{{ $secondaryButtonUrl ?? '#' }}"
                            class="nv-btn-secondary text-sm font-semibold leading-6 text-gray-900"
                        >
                            {{ $secondaryButtonLabel }}
                            <span aria-hidden="true">→</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
