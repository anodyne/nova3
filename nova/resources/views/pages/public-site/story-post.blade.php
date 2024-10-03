@use('Illuminate\Support\Number')

<x-public-layout>
    <div class="@container advanced-page story-post">
        <div class="story-post-container">
            <div class="main-column">
                <div class="pretitle">{{ $story->title }}</div>

                <x-public::h2>{{ $post->title }}</x-public::h2>

                <div class="metadata">
                    <div class="metadata-item metadata-item-sm">
                        <div class="metadata-item-icon">
                            <x-icon :name="$post->postType->icon" size="sm"></x-icon>
                        </div>
                        <div class="metadata-item-label">{{ $post->postType->name }}</div>
                    </div>
                    <div class="metadata-item metadata-item-sm">
                        <div class="metadata-item-leading">Published</div>
                        <div class="metadata-item-label">
                            {{ format_date($post->published_at) }}
                        </div>
                    </div>
                    <div class="metadata-item metadata-item-sm">
                        <div class="metadata-item-leading">Reading time</div>
                        <div class="metadata-item-label">{{ Number::format(ceil($post->word_count / 200)) }}m</div>
                    </div>
                    <div class="metadata-item metadata-item-sm">
                        <div class="metadata-item-leading">Words</div>
                        <div class="metadata-item-label">
                            {{ Number::format($post->word_count) }}
                        </div>
                    </div>
                </div>

                @if ($post->postType->fields->showMetaFields())
                    <div class="metadata">
                        @if ($post->postType->fields->location->enabled && filled($post->location))
                            <div class="metadata-item">
                                <div class="metadata-item-icon">
                                    <x-icon name="location" size="md"></x-icon>
                                </div>
                                <div class="metadata-item-label">{{ $post->location }}</div>
                            </div>
                        @endif

                        @if ($post->postType->fields->day->enabled && filled($post->day))
                            <div class="metadata-item">
                                <div class="metadata-item-icon">
                                    <x-icon name="calendar" size="md"></x-icon>
                                </div>
                                <div class="metadata-item-label">{{ $post->day }}</div>
                            </div>
                        @endif

                        @if ($post->postType->fields->time->enabled && filled($post->time))
                            <div class="metadata-item">
                                <div class="metadata-item-icon">
                                    <x-icon name="clock" size="md"></x-icon>
                                </div>
                                <div class="metadata-item-label">{{ $post->time }}</div>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="post-content">
                    {!! $post->content !!}
                </div>

                @if (filled($previousPost) || filled($nextPost))
                    <div class="post-navigation-container">
                        @if (filled($previousPost))
                            <div class="previous">
                                <a
                                    class="pill-link"
                                    aria-label="Previous post: {{ $previousPost->title }}"
                                    href="{{ route('public.story-post', [$story, $previousPost]) }}"
                                >
                                    <svg viewBox="0 0 20 20" fill="none" aria-hidden="true" data-slot="icon">
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m11.5 6.5 3 3.5m0 0-3 3.5m3-3.5h-9"
                                        ></path>
                                    </svg>
                                    Previous
                                </a>
                                <a
                                    tabindex="-1"
                                    aria-hidden="true"
                                    class="link"
                                    href="{{ route('public.story-post', [$story, $previousPost]) }}"
                                >
                                    {{ $previousPost->title }}
                                </a>
                            </div>
                        @endif

                        @if (filled($nextPost))
                            <div class="next">
                                <a
                                    class="pill-link"
                                    aria-label="Next post: {{ $nextPost->title }}"
                                    href="{{ route('public.story-post', [$story, $nextPost]) }}"
                                >
                                    Next
                                    <svg viewBox="0 0 20 20" fill="none" aria-hidden="true" data-slot="icon">
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m11.5 6.5 3 3.5m0 0-3 3.5m3-3.5h-9"
                                        ></path>
                                    </svg>
                                </a>
                                <a
                                    tabindex="-1"
                                    aria-hidden="true"
                                    class="link"
                                    href="{{ route('public.story-post', [$story, $nextPost]) }}"
                                >
                                    {{ $nextPost->title }}
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="secondary-column">
                <dl class="secondary-column-container">
                    @if ($post->postType->fields->rating->enabled)
                        <div class="ratings-container">
                            <x-rating.display
                                type="language"
                                :rating="$post->rating_language"
                                size="md"
                                show-details
                            ></x-rating.display>
                            <x-rating.display
                                type="sex"
                                :rating="$post->rating_sex"
                                size="md"
                                show-details
                            ></x-rating.display>
                            <x-rating.display
                                type="violence"
                                :rating="$post->rating_violence"
                                size="md"
                                show-details
                            ></x-rating.display>
                        </div>
                    @endif

                    <div class="authors-container">
                        @foreach ($post->characterAuthors as $characterAuthor)
                            <div class="author">
                                <x-avatar :src="$characterAuthor->avatar_url" size="sm"></x-avatar>
                                <div>{{ $characterAuthor->name }}</div>
                            </div>
                        @endforeach

                        @foreach ($post->userAuthors as $userAuthor)
                            @if (filled($userAuthor->pivot->as))
                                <div class="author">
                                    <x-avatar :src="$userAuthor->avatar_url" size="sm"></x-avatar>
                                    <div>{{ $userAuthor->pivot->as }}</div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-public-layout>
