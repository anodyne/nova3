<div
    @class([
        'not-prose',
        'dark' => $dark,
    ])
    style="
        --bgColor: {{ $bgColor ?? 'transparent' }};
        --cardBg: {{ $cardBg ?? 'transparent' }};
        --cardBgOpacity: {{ $card ? $cardBgOpacity/100 : 1 }};
    "
>
    <div class="mx-auto max-w-7xl bg-[--bgColor] px-8 py-8 font-[family-name:Flow_Circular]">
        <div
            @class([
                'relative rounded-xl shadow-lg ring-1 ring-inset' => $card,
                'before:absolute before:inset-0 before:rounded-xl before:bg-[--cardBg]' => $card,
                'dark' => $card && $cardDark,
                'ring-black/5' => $card && ! $cardDark,
                'ring-white/5' => $card && $cardDark,
                'before:opacity-[--cardBgOpacity]' => $card && $cardBgOpacity > 0,
                'backdrop-blur' => $card && $cardBgBlur,
                match ($cardSpacing ?? null) {
                    'small' => 'p-4',
                    'medium' => 'p-8',
                    'large' => 'p-16',
                    default => 'p-0',
                } => $card,
            ])
        >
            <div
                @class([
                    'nv-cta-wrapper relative flex max-w-2xl flex-col',
                    'mx-auto items-center text-center' => $headerOrientation === 'center',
                    'ml-auto items-end text-right' => $headerOrientation === 'right',
                ])
            >
                @if (filled($heading) || filled($description))
                    @if (filled($heading))
                        <x-public::preview.h2>{{ $heading }}</x-public::preview.h2>
                    @endif

                    @if (filled($description))
                        <x-public::preview.lead
                            @class([
                                'mt-4' => filled($heading),
                            ])
                        >
                            {{ $description }}
                        </x-public::preview.lead>
                    @endif
                @endif

                @if (filled($primaryButtonUrl) || filled($secondaryButtonUrl))
                    <div
                        @class([
                            'nv-cta-buttons mt-10 flex items-center gap-x-6',
                            'justify-center' => $headerOrientation === 'center',
                            'flex-row-reverse' => $headerOrientation === 'right',
                        ])
                    >
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
        </div>
    </div>
</div>
