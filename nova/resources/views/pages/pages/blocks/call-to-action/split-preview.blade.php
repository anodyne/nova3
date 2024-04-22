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
                'backdrop-blur-md' => $card && $cardBgBlur,
                match ($cardSpacing ?? null) {
                    'small' => 'p-4',
                    'medium' => 'p-8',
                    'large' => 'p-16',
                    default => 'p-0',
                } => $card && filled($cardSpacing),
            ])
        >
            <div
                class="nv-cta-wrapper flex items-center justify-between"
            >
                <div class="max-w-2xl">
                    @if (filled($heading))
                        <x-public::preview.h2>{{ $heading }}</x-public::preview.h2>
                    @endif

                    @if (filled($description))
                        <x-public::preview.lead
                            @class([
                                'mt-4' => filled($heading),
                            ])
                            markdown
                        >
                            {{ $description }}
                        </x-public::preview.lead>
                    @endif
                </div>

                @if (filled($primaryButtonUrl) || filled($secondaryButtonUrl))
                    <div class="nv-cta-buttons-ctn flex items-center gap-x-6 mt-0 shrink-0">
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
