<x-dynamic-component component="layouts.theme">
    <div class="@container advanced-page story-post">
        <div
            class="story-post-container"
            x-data="{ showContentWarning: @js($post->show_content_warning_for_public_site) }"
        >
            <div class="main-column">
                {{ NovaView::renderHook('public::story-post.main-column.before') }}

                <div class="pretitle">{{ $story->title }}</div>

                <x-public::h2>{{ $post->title }}</x-public::h2>

                <div class="metadata">
                    <div class="metadata-item metadata-item-sm">
                        <div class="metadata-item-icon">
                            <x-icon :name="$post->postType->icon" size="sm"/>
                        </div>
                        <div class="metadata-item-label">{{ $post->postType->name }}</div>
                    </div>
                    <div class="metadata-item metadata-item-sm">
                        <div class="metadata-item-leading">Published</div>
                        <div class="metadata-item-label">
                            {{ $post->published_at->formatDate() }}
                        </div>
                    </div>
                    <div class="metadata-item metadata-item-sm">
                        <div class="metadata-item-leading">Reading time</div>
                        <div class="metadata-item-label">{{ $post->reading_time }}</div>
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
                                    <x-icon :name="Tabler::MapPin" size="md"/>
                                </div>
                                <div class="metadata-item-label">{{ $post->location }}</div>
                            </div>
                        @endif

                        @if ($post->postType->fields->day->enabled && filled($post->day))
                            <div class="metadata-item">
                                <div class="metadata-item-icon">
                                    <x-icon :name="Tabler::Calendar" size="md"/>
                                </div>
                                <div class="metadata-item-label">{{ $post->day }}</div>
                            </div>
                        @endif

                        @if ($post->postType->fields->time->enabled && filled($post->time))
                            <div class="metadata-item">
                                <div class="metadata-item-icon">
                                    <x-icon :name="Tabler::Clock" size="md"/>
                                </div>
                                <div class="metadata-item-label">{{ $post->time }}</div>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="post-content" x-show="!showContentWarning" x-cloak>
                    {!! $post->content !!}
                </div>

                <div class="post-content-warning" x-show="showContentWarning" x-cloak>
                    <div class="heading">
                        <x-icon :name="Tabler::AlertTriangle" size="xl"/>
                        <x-public::h2>Warning</x-public::h2>
                    </div>

                    <div class="post-content">
                        <p>
                            This post includes mature content that may not be suitable for all audiences and could be
                            sensitive or triggering for some readers.
                        </p>

                        <ul>
                            @if ($post->rating_language->value >= settings('ratings.language.warningThreshold'))
                                <li>{{ settings('ratings.language.warningThresholdMessage') }}</li>
                            @endif

                            @if ($post->rating_sex->value >= settings('ratings.sex.warningThreshold'))
                                <li>{{ settings('ratings.sex.warningThresholdMessage') }}</li>
                            @endif

                            @if ($post->rating_violence->value >= settings('ratings.violence.warningThreshold'))
                                <li>{{ settings('ratings.violence.warningThresholdMessage') }}</li>
                            @endif
                        </ul>

                        <p>By proceeding, you acknowledge the nature of this content.</p>
                    </div>

                    <x-public::button type="button" x-on:click="showContentWarning = false">Continue</x-public::button>

                    @if (filled($post->summary))
                        <div class="summary">
                            <hr/>

                            <div class="post-content">
                                <h4>
                                    The following summary has been provided for this
                                    {{ str($post->postType->name)->lower() }}:
                                </h4>

                                {!! $post->summary !!}
                            </div>
                        </div>
                    @endif
                </div>

                {{ NovaView::renderHook('public::story-post.main-column.after') }}

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
                    {{ NovaView::renderHook('public::story-post.secondary-column.before') }}

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

                    {{ NovaView::renderHook('public::story-post.secondary-column.after') }}
                </dl>
            </div>
        </div>
    </div>
</x-dynamic-component>
