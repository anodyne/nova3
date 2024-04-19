<div @class([
    'not-prose',
    'bg-white' => ! $dark,
    'dark bg-gray-900' => $dark,
])>
    <div class="mx-auto max-w-7xl px-8 py-8 font-[family-name:Flow_Circular]">
        <div class="nv-hero-ctn mx-auto max-w-2xl text-center">
            @if (filled($calloutText))
                <div
                    @class([
                        'nv-hero-callout-ctn',
                        'mt-16' => isset($orientation) && $orientation === 'bottom',
                    ])
                >
                    <x-public::preview.callout
                        href="{{ $calloutUrl ?? '#' }}"
                        :callout-color="$calloutColor ?? 'Gray'"
                    >
                        {{ $calloutText }}
                    </x-public::preview.callout>
                </div>
            @endif

            @if (filled($heading))
                <x-public::preview.h1
                    @class([
                        'mt-10' => filled($calloutText),
                        'mt-16' => blank($calloutText) && isset($orientation) && $orientation === 'bottom',
                    ])
                >
                    {{ $heading }}
                </x-public::preview.h1>
            @endif

            @if (filled($description))
                <x-public::preview.lead
                    @class([
                        'mt-6' => filled($heading),
                    ])
                >
                    {{ $description }}
                </x-public::preview.lead>
            @endif

            @if (filled($primaryButtonUrl) || filled($secondaryButtonUrl))
                <div class="nv-hero-buttons-ctn mt-10 flex flex-row items-center justify-center gap-6">
                    @if (filled($primaryButtonLabel) && filled($primaryButtonUrl))
                        <x-public::preview.button
                            :href="$primaryButtonUrl"
                            :bg-color="$primaryButtonBgColor"
                            :text-color="$primaryButtonTextColor ?? null"
                            primary
                        >
                            {{ $primaryButtonLabel }}
                        </x-public::preview.button>
                    @endif

                    @if (filled($secondaryButtonUrl) && filled($secondaryButtonLabel))
                        <x-public::preview.button :href="$secondaryButtonUrl">
                            {{ $secondaryButtonLabel }}
                        </x-public::preview.button>
                    @endif
                </div>
            @endif
        </div>

        @if ($mediaType !== 'none')
            <div
                @class([
                    'nv-hero-image-ctn flow-root',
                    'order-none mt-24' => isset($orientation) && $orientation === 'bottom',
                    'order-first mb-24' => isset($orientation) && $orientation === 'top',
                ])
            >
                @if (isset($image) && filled($image))
                    <img
                        src="{{ asset('media/'.$image) }}"
                        alt=""
                        width="2432"
                        height="1442"
                        class="nv-hero-image rounded-3xl shadow-2xl ring-1 ring-gray-900/10 dark:bg-white/5 dark:ring-white/10"
                    />
                @endif

                @if (isset($video) && filled($video))
                    <x-embed :url="$video"></x-embed>
                @endif
            </div>
        @endif
    </div>
</div>
