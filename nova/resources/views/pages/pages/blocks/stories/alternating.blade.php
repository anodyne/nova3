<div
    @class([
        '@container',
        'nv-stories nv-stories-alternating',
        'dark' => $dark,
    ])
    style="--bgColor: {{ $bgColor ?? 'transparent' }}"
>
    <x-public::block.wrapper
        :spacing-horizontal="$spacingHorizontal ?? null"
        :spacing-vertical="$spacingVertical ?? null"
    >
        <div
            @class([
                'nv-stories-wrapper flex',
                'content-end justify-end' => $headerOrientation === 'right',
            ])
        >
            <div
                @class([
                    'nv-stories-intro max-w-2xl',
                    'mx-auto @lg:text-center' => $headerOrientation === 'center',
                    '@lg:text-right' => $headerOrientation === 'right',
                ])
            >
                @if (filled($heading))
                    <x-public::h2>
                        {{ $heading }}
                    </x-public::h2>
                @endif

                @if (filled($description))
                    <x-public::lead
                        @class([
                            'mt-6' => filled($heading),
                        ])
                        markdown
                    >
                        {{ $description }}
                    </x-public::lead>
                @endif
            </div>
        </div>

        <livewire:pages-alternating-stories
            :dark="$dark"
            :type="$storyType"
            :show-description="$showStoryDescription"
            :show-stats="$showStoryStats"
            :selected-stories="$selectedStories ?? []"
        />
    </x-public::block.wrapper>
</div>
