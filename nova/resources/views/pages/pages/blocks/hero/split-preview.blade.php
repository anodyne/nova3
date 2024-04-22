<div @class([
    'not-prose',
    'bg-white' => ! $dark,
    'dark bg-gray-900' => $dark,
])>
    <div class="mx-auto max-w-7xl px-8 py-8 font-[family-name:Flow_Circular]">
        <div class="grid grid-cols-2 gap-8">
            <div>
                @if (filled($calloutText))
                    <x-public::preview.callout :callout-color="$calloutColor ?? 'Gray'"></x-public::preview.callout>
                @endif

                @if (filled($heading))
                    <x-public::preview.h1
                        @class([
                            'mt-10' => filled($calloutText),
                            'mt-16' => blank($calloutText),
                        ])
                    >
                        {{ $heading }}
                    </x-public::preview.h1>
                @endif

                @if (filled($description))
                    <x-public::preview.lead
                        @class([
                            'mt-6' => filled($heading),
                            'mt-10' => filled($calloutText) && blank($heading),
                            'mt-16' => blank($calloutText) && blank($heading),
                        ])
                    ></x-public::preview.lead>
                @endif

                @if (filled($primaryButtonUrl) || filled($secondaryButtonUrl))
                    <div class="mt-10 flex items-center gap-6">
                        @if (filled($primaryButtonLabel) && filled($primaryButtonUrl))
                            <x-public::preview.button
                                :bg-color="$primaryButtonBgColor"
                                :text-color="$primaryButtonTextColor ?? null"
                                primary
                            >
                                Primary button
                            </x-public::preview.button>
                        @endif

                        @if (filled($secondaryButtonUrl) && filled($secondaryButtonLabel))
                            <x-public::preview.button>Secondary button</x-public::preview.button>
                        @endif
                    </div>
                @endif
            </div>

            @if ($mediaType !== 'none')
                <div
                    @class([
                        'flex items-end',
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
                            class="w-[76rem] rounded-3xl shadow-2xl ring-1 ring-gray-900/10 dark:bg-white/5 dark:ring-white/10"
                        />
                    @endif

                    @if (isset($video) && filled($video))
                        <x-embed :url="$video"></x-embed>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
