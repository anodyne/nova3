<div
    @class([
        '@container',
        'nv-cta nv-cta-split',
        'dark' => $dark,
    ])
    style="
        --bgColor: {{ $bgColor ?? 'transparent' }};
        --cardBg: {{ $cardBg ?? 'transparent' }};
        --cardBgOpacity: {{ $card ? $cardBgOpacity/100 : 1 }};
    "
>
    <x-public::block.wrapper
        :bg-option="$bgOption"
        :bg-image-intensity="$bgImageIntensity ?? null"
        :spacing-horizontal="$spacingHorizontal ?? null"
        :spacing-vertical="$spacingVertical ?? null"
    >
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
                class="nv-cta-wrapper @4xl:flex @4xl:items-center @4xl:justify-between"
            >
                <div class="max-w-2xl">
                    @if (filled($heading))
                        <x-public::h2>{{ $heading }}</x-public::h2>
                    @endif

                    @if (filled($description))
                        <x-public::lead
                            @class([
                                'mt-4' => filled($heading),
                            ])
                            markdown
                        >
                            {{ $description }}
                        </x-public::lead>
                    @endif
                </div>

                @if (filled($primaryButtonUrl) || filled($secondaryButtonUrl))
                    <div class="nv-cta-buttons-ctn @xs:mt-10 flex items-center gap-x-6 @4xl:mt-0 @4xl:shrink-0">
                        @if (filled($primaryButtonLabel) && filled($primaryButtonUrl))
                            <x-public::button
                                :href="$primaryButtonUrl"
                                :bg-color="$primaryButtonBgColor"
                                :text-color="$primaryButtonTextColor ?? null"
                                primary
                            >
                                {{ $primaryButtonLabel }}
                            </x-public::button>
                        @endif

                        @if (filled($secondaryButtonUrl) && filled($secondaryButtonLabel))
                            <x-public::button :href="$secondaryButtonUrl">
                                {{ $secondaryButtonLabel }}
                            </x-public::button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </x-public::block.wrapper>
</div>
