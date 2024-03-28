<div class="nv-stories-ctn @sm:mt-20 @lg:mt-24 @xs:mt-16 space-y-24">
    @foreach ($stories as $story)
        <div class="nv-stories-story-wrapper @xs:flex-col flex gap-16 @5xl:flex-row">
            <div
                @class([
                    'nv-stories-story-ctn w-full max-w-xl',
                    '@5xl:order-last' => $loop->even,
                ])
            >
                <x-public::h2>
                    {{ $story?->title }}
                </x-public::h2>

                @if ($showDescription && filled($story?->description))
                    <x-public::lead class="mt-4" markdown>
                        {{ $story?->description }}
                    </x-public::lead>
                @endif

                <div class="mt-6 flex items-center">
                    <x-public::button href="#" primary>Go to story</x-public::button>
                </div>

                @if ($showStats)
                    <div class="nv-stories-story-stats @lg:grid-cols-2 mt-8 grid gap-y-8">
                        <div class="nv-stories-story-stat border-l-2 border-gray-950/10 py-2 pl-6 dark:border-white/10">
                            <h3 class="text-base/7 text-gray-600 dark:text-gray-400">Total posts</h3>

                            <div
                                class="nv-stat-value order-first font-[family-name:--font-header] text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl"
                            >
                                {{ $story->posts_count }}
                            </div>
                        </div>
                        <div class="nv-stories-story-stat border-l-2 border-gray-950/10 py-2 pl-6 dark:border-white/10">
                            <h3 class="text-base/7 text-gray-600 dark:text-gray-400">Total words</h3>

                            <div
                                class="nv-stat-value order-first font-[family-name:--font-header] text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl"
                            >
                                {{ number_format($story->posts_sum_word_count ?? 0) }}
                            </div>
                        </div>

                        @if ($story->children->count() > 0)
                            <div class="nv-stories-story-stat border-l-2 border-gray-950/10 py-2 pl-6 dark:border-white/10">
                                <h3 class="text-base/7 text-gray-600 dark:text-gray-400">
                                    Total posts (all stories within)
                                </h3>

                                <div
                                    class="nv-stat-value order-first font-[family-name:--font-header] text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl"
                                >
                                    {{ $story->recursive_posts_count }}
                                </div>
                            </div>
                            <div class="nv-stories-story-stat border-l-2 border-gray-950/10 py-2 pl-6 dark:border-white/10">
                                <h3 class="text-base/7 text-gray-600 dark:text-gray-400">
                                    Total words (all stories within)
                                </h3>

                                <div
                                    class="nv-stat-value order-first font-[family-name:--font-header] text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl"
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
                        'nv-stories-story-image flex-1 shrink-0',
                        '@5xl:order-first' => $loop->even,
                    ])
                >
                    <img
                        src="{{ $story->getFirstMediaUrl('story-image') }}"
                        alt=""
                        width="2432"
                        height="1442"
                        class="h-auto w-[76rem] rounded-3xl shadow-2xl ring-1 ring-gray-900/10 dark:ring-white/10"
                    />
                </div>
            @endif
        </div>
    @endforeach
</div>
