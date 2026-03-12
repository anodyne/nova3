@use('Nova\Pages\Enums\BoxShadow')
@use('Nova\Pages\Enums\Radius')

@php
    $imageRadius = Radius::tryFrom(data_get($blockSettings, 'image.radius') ?? 'none');
    $imageShadow = BoxShadow::tryFrom(data_get($blockSettings, 'image.shadow') ?? 'none');
@endphp

<div
    class="nv-stories-ctn @sm:mt-20 @lg:mt-24 @xs:mt-16 space-y-24"
    style="
        --primary-text-color: {{ data_get($blockSettings, 'primary-text-color') }};
        --secondary-text-color: {{ data_get($blockSettings, 'secondary-text-color') }};
    "
>
    @foreach ($stories as $story)
        <div class="nv-stories-story-wrapper @xs:flex-col flex gap-16 @5xl:flex-row">
            <div
                @class([
                    'nv-stories-story-ctn w-full max-w-xl',
                    '@5xl:order-last' => $loop->even,
                ])
            >
                <x-public::h2 class="text-(--primary-text-color)">
                    {{ $story?->title }}
                </x-public::h2>

                @if ($showDescription && filled($story?->description))
                    <x-public::lead class="mt-4 text-(--secondary-text-color)" markdown>
                        {{ $story?->description }}
                    </x-public::lead>
                @endif

                <div
                    class="mt-6 flex items-center"
                    style="
                        --bg-color: {{ data_get($blockSettings, 'button.bg-color') }};
                        --text-color: {{ data_get($blockSettings, 'button.text-color') }};
                        --border-color: {{ data_get($blockSettings, 'button.border-color') }};
                    "
                >
                    <x-public::block.button :button="data_get($blockSettings, 'button')">
                        Go to story
                    </x-public::block.button>
                </div>

                @if ($showStats)
                    <div class="nv-stories-story-stats @lg:grid-cols-2 mt-8 grid gap-y-8">
                        <div class="nv-stories-story-stat py-2">
                            <h3 class="text-base/7 text-(--secondary-text-color)">Total posts</h3>

                            <div
                                class="nv-stat-value order-first font-(family-name:--font-header) text-3xl font-semibold tracking-tight text-(--primary-text-color) sm:text-5xl"
                            >
                                {{ $story->posts_count }}
                            </div>
                        </div>
                        <div class="nv-stories-story-stat py-2">
                            <h3 class="text-base/7 text-(--secondary-text-color)">Total words</h3>

                            <div
                                class="nv-stat-value order-first font-(family-name:--font-header) text-3xl font-semibold tracking-tight text-(--primary-text-color) sm:text-5xl"
                            >
                                {{ number_format($story->posts_sum_word_count ?? 0) }}
                            </div>
                        </div>

                        @mysql
                            @if ($story->children->count() > 0)
                                <div class="nv-stories-story-stat py-2">
                                    <h3 class="text-base/7 text-(--primary-text-color)">
                                        Total posts (all stories within)
                                    </h3>

                                    <div
                                        class="nv-stat-value order-first font-(family-name:--font-header) text-3xl font-semibold tracking-tight text-(--secondary-text-color) sm:text-5xl"
                                    >
                                        {{ $story->recursive_posts_count }}
                                    </div>
                                </div>
                                <div class="nv-stories-story-stat py-2">
                                    <h3 class="text-base/7 text-(--primary-text-color)">
                                        Total words (all stories within)
                                    </h3>

                                    <div
                                        class="nv-stat-value order-first font-(family-name:--font-header) text-3xl font-semibold tracking-tight text-(--secondary-text-color) sm:text-5xl"
                                    >
                                        {{ number_format($story->recursive_posts_sum_word_count ?? 0) }}
                                    </div>
                                </div>
                            @endif
                        @endmysql
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
                        @class([
                            'h-auto w-[76rem]',
                            $imageRadius?->getTailwindClasses(),
                            $imageShadow?->getTailwindClasses(),
                        ])
                    />
                </div>
            @endif
        </div>
    @endforeach
</div>
