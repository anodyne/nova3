<div
    @class([
        '@container',
        'nv-features nv-features-alternating',
        'dark' => $dark,
    ])
    style="--bgColor: {{ $bgColor ?? 'transparent' }}"
>
    <x-public::block.wrapper
        :spacing-horizontal="$spacingHorizontal ?? null"
        :spacing-vertical="$spacingVertical ?? null"
    >
        <x-public::block.header
            :heading="$heading ?? null"
            :description="$description ?? null"
            :orientation="$headerOrientation"
        ></x-public::block.header>

        <div class="@xs:mt-16 @lg:mt-20 space-y-24 @2xl:mt-24">
            @foreach ($features as $feature)
                <div class="flex gap-x-16">
                    <div
                        @class([
                            'max-w-xl',
                            'order-last' => $loop->even,
                        ])
                    >
                        @if (isset($feature->content))
                            <div
                                @class([
                                    'prose prose-lg max-w-none font-[family-name:--font-body]',
                                    'prose-h1:font-[family-name:--font-header]',
                                    'prose-h2:font-[family-name:--font-header]',
                                    'prose-h3:font-[family-name:--font-header]',
                                    'prose-h4:font-[family-name:--font-header]',
                                    'dark:prose-invert',
                                ])
                            >
                                {!! scribble($feature->content ?? ['content' => null])->toHtml() !!}
                            </div>
                        @endif
                    </div>

                    <div
                        @class([
                            'flex-1 overflow-hidden rounded-xl ring-1 ring-gray-950/5 dark:ring-white/5',
                            'order-first' => $loop->even,
                        ])
                    >
                        @if (isset($feature->image) && filled($feature->image))
                            <img
                                src="{{ asset('media/'.$feature->image) }}"
                                alt=""
                                width="2432"
                                height="1442"
                                @class([
                                    'nv-hero-image w-[76rem] rounded-3xl shadow-2xl ring-1 ring-gray-900/10 dark:bg-white/5 dark:ring-white/10',
                                ])
                            />
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </x-public::block.wrapper>
</div>
