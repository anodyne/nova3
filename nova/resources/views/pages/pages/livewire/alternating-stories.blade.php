<div class="@sm:mt-20 @lg:mt-24 @xs:mt-16 space-y-24">
    @foreach ($stories as $story)
        <div class="@xs:flex-col flex gap-16 @5xl:flex-row">
            <div
                @class([
                    'w-full max-w-xl',
                    '@5xl:order-last' => $loop->even,
                ])
            >
                <h2
                    @class([
                        'nv-features-heading font-[family-name:--font-header] text-2xl font-bold tracking-tight sm:text-3xl',
                        'text-gray-900' => ! $dark,
                        'text-white' => $dark,
                    ])
                >
                    {{ $story?->title }}
                </h2>

                @if ($showDescription && filled($story?->description))
                    <p
                        @class([
                            'mt-4 text-base/7',
                            'text-gray-900' => ! $dark,
                            'text-white' => $dark,
                        ])
                    >
                        {{ $story?->description }}
                    </p>
                @endif

                <div class="nv-cta-buttons-ctn mt-6 flex items-center">
                    <a
                        href="#"
                        @class([
                            'nv-btn-primary rounded-lg px-3.5 py-2.5 text-center text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2',
                            'nv-btn-primary-light bg-gray-800 text-white hover:bg-gray-950' => ! $dark,
                            'nv-btn-primary-dark bg-white bg-opacity-75 text-gray-950 backdrop-blur hover:bg-opacity-100' => $dark,
                        ])
                    >
                        Go to story
                    </a>
                </div>

                @if ($showStats)
                    <div class="@lg:grid-cols-2 mt-8 grid gap-y-8">
                        <div
                            @class([
                                'border-l-2 py-2 pl-6',
                                'border-gray-950/10' => ! $dark,
                                'border-white/10' => $dark,
                            ])
                        >
                            <h3
                                @class([
                                    'nv-stat-heading text-base/7',
                                    'text-gray-600' => ! $dark,
                                    'text-gray-400' => $dark,
                                ])
                            >
                                Total posts
                            </h3>

                            <div
                                @class([
                                    'nv-stat-value order-first font-[family-name:--font-header] text-3xl font-semibold tracking-tight sm:text-5xl',
                                    'text-gray-900' => ! $dark,
                                    'text-white' => $dark,
                                ])
                            >
                                {{ $story->posts_count }}
                            </div>
                        </div>
                        <div
                            @class([
                                'border-l-2 py-2 pl-6',
                                'border-gray-950/10' => ! $dark,
                                'border-white/10' => $dark,
                            ])
                        >
                            <h3
                                @class([
                                    'nv-stat-heading text-base/7',
                                    'text-gray-600' => ! $dark,
                                    'text-gray-400' => $dark,
                                ])
                            >
                                Total words
                            </h3>

                            <div
                                @class([
                                    'nv-stat-value order-first font-[family-name:--font-header] text-3xl font-semibold tracking-tight sm:text-5xl',
                                    'text-gray-900' => ! $dark,
                                    'text-white' => $dark,
                                ])
                            >
                                {{ number_format($story->posts_sum_word_count ?? 0) }}
                            </div>
                        </div>

                        @if ($story->children->count() > 0)
                            <div
                                @class([
                                    'border-l-2 py-2 pl-6',
                                    'border-gray-950/10' => ! $dark,
                                    'border-white/10' => $dark,
                                ])
                            >
                                <h3
                                    @class([
                                        'nv-stat-heading text-base/7',
                                        'text-gray-600' => ! $dark,
                                        'text-gray-400' => $dark,
                                    ])
                                >
                                    Total posts (all stories within)
                                </h3>

                                <div
                                    @class([
                                        'nv-stat-value order-first font-[family-name:--font-header] text-3xl font-semibold tracking-tight sm:text-5xl',
                                        'text-gray-900' => ! $dark,
                                        'text-white' => $dark,
                                    ])
                                >
                                    {{ $story->recursive_posts_count }}
                                </div>
                            </div>
                            <div
                                @class([
                                    'border-l-2 py-2 pl-6',
                                    'border-gray-950/10' => ! $dark,
                                    'border-white/10' => $dark,
                                ])
                            >
                                <h3
                                    @class([
                                        'nv-stat-heading text-base/7',
                                        'text-gray-600' => ! $dark,
                                        'text-gray-400' => $dark,
                                    ])
                                >
                                    Total words (all stories within)
                                </h3>

                                <div
                                    @class([
                                        'nv-stat-value order-first font-[family-name:--font-header] text-3xl font-semibold tracking-tight sm:text-5xl',
                                        'text-gray-900' => ! $dark,
                                        'text-white' => $dark,
                                    ])
                                >
                                    {{ number_format($story->recursive_posts_sum_word_count ?? 0) }}
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            @if (filled($story?->getFirstMediaUrl('story-image')))
                <div
                    @class([
                        'flex-1 shrink-0',
                        '@5xl:order-first' => $loop->even,
                    ])
                >
                    <img
                        src="{{ $story->getFirstMediaUrl('story-image') }}"
                        alt=""
                        width="2432"
                        height="1442"
                        @class([
                            'nv-hero-image h-auto w-[76rem] rounded-3xl shadow-2xl ring-1',
                            'ring-gray-900/10' => ! $dark,
                            'ring-white/10' => $dark,
                        ])
                    />
                </div>
            @endif
        </div>
    @endforeach
</div>
