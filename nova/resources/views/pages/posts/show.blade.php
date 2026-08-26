<x-admin-layout>
    <div
        class="grid gap-8 lg:grid-cols-3"
        x-data="{
            showContentWarning:
                {{ Js::from($post->show_content_warning_for_admin_site) }},
        }"
    >
        <div class="lg:col-span-2">
            <div class="space-y-2">
                <p class="text-sm/6">
                    <a
                        href="{{ route('admin.stories.show', $story) }}"
                        class="text-gray-500 underline hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300"
                    >
                        {{ $story->title }}
                    </a>
                </p>
                <x-h1>{{ $post->title }}</x-h1>
            </div>

            <x-metadata.group gap="lg" class="mt-4">
                <x-metadata label="Post type" :value="$post->postType->name"/>

                <x-metadata label="Reading time" :value="$post->reading_time"/>

                <x-metadata label="Words" :value="Number::format($post->word_count ?? 0)"/>

                @if ($post->is_published)
                    <x-metadata label="Published" :value="$post->published_at->formatDate()"/>
                @endif
            </x-metadata.group>

            @if ($post->postType->fields->showMetaFields())
                <x-metadata.group gap="lg" class="mt-8">
                    @if ($post->postType->fields->location->enabled && filled($post->location))
                        <x-metadata :icon="Tabler::MapPin" :value="$post->location"/>
                    @endif

                    @if ($post->postType->fields->day->enabled && filled($post->day))
                        <x-metadata :icon="Tabler::Calendar" :value="$post->day"/>
                    @endif

                    @if ($post->postType->fields->time->enabled && filled($post->time))
                        <x-metadata :icon="Tabler::Clock" :value="$post->time"/>
                    @endif
                </x-metadata.group>
            @endif

            <div class="prose dark:prose-invert mt-8 max-w-none" x-cloak x-show="!showContentWarning">
                {!! $post->content !!}
            </div>

            <div x-show="showContentWarning" x-cloak>
                <div class="flex items-center gap-x-3">
                    <x-icon :name="Tabler::AlertTriangle" size="xl" class="text-danger-500"/>
                    <h1 class="text-danger-600 block text-4xl leading-loose font-extrabold tracking-tight">Warning</h1>
                </div>

                <div class="prose dark:prose-invert mb-8">
                    <p>
                        This post includes mature content that may not be suitable for all audiences and could be
                        sensitive or triggering for some readers.
                    </p>

                    <ul>
                        @if ($post->rating_language->value >= $post->contentRatingThreshold('language', forUser: true))
                            <li>{{ settings('ratings.language.warningThresholdMessage') }}</li>
                        @endif

                        @if ($post->rating_sex->value >= $post->contentRatingThreshold('sex', forUser: true))
                            <li>{{ settings('ratings.sex.warningThresholdMessage') }}</li>
                        @endif

                        @if ($post->rating_violence->value >= $post->contentRatingThreshold('violence', forUser: true))
                            <li>{{ settings('ratings.violence.warningThresholdMessage') }}</li>
                        @endif
                    </ul>

                    <p>By proceeding, you acknowledge the nature of this content.</p>
                </div>

                <x-button type="button" x-on:click="showContentWarning = false">Continue</x-button>

                @if (filled($post->summary))
                    <div class="mt-12 max-w-2xl">
                        <hr class="mb-12 max-w-lg border-gray-200 dark:border-gray-800"/>

                        <div class="prose dark:prose-invert">
                            <h4>
                                The following summary has been provided for this
                                {{ str($post->postType->name)->lower() }}:
                            </h4>

                            <p>{!! $post->summary !!}</p>
                        </div>
                    </div>
                @endif
            </div>

            @if (filled($previousPost) || filled($nextPost))
                <div class="mt-16 flex">
                    @if (filled($previousPost))
                        <div class="flex flex-col items-start gap-3">
                            <a
                                class="inline-flex items-center justify-center gap-0.5 overflow-hidden rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-900 transition hover:bg-gray-200 dark:bg-gray-800/40 dark:text-gray-400 dark:ring-1 dark:ring-gray-800 dark:ring-inset dark:hover:bg-gray-800 dark:hover:text-gray-300 [&>[data-slot=icon]]:-ml-1"
                                aria-label="Previous post: {{ $previousPost->title }}"
                                href="{{ route('admin.posts.show', [$story, $previousPost]) }}"
                            >
                                <x-icon.micro.chevron-left class="text-gray-500"/>
                                <span>Previous</span>
                            </a>
                            <a
                                tabindex="-1"
                                aria-hidden="true"
                                class="text-base font-semibold text-gray-900 transition hover:text-gray-600 dark:text-white dark:hover:text-gray-300"
                                href="{{ route('admin.posts.show', [$story, $previousPost]) }}"
                            >
                                {{ $previousPost->title }}
                            </a>
                        </div>
                    @endif

                    @if (filled($nextPost))
                        <div class="ml-auto flex flex-col items-end gap-3">
                            <a
                                class="inline-flex items-center justify-center gap-0.5 overflow-hidden rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-900 transition hover:bg-gray-200 dark:bg-gray-800/40 dark:text-gray-400 dark:ring-1 dark:ring-gray-800 dark:ring-inset dark:hover:bg-gray-800 dark:hover:text-gray-300 [&>[data-slot=icon]]:-mr-1"
                                aria-label="Next post: {{ $nextPost->title }}"
                                href="{{ route('admin.posts.show', [$story, $nextPost]) }}"
                            >
                                <span>Next</span>
                                <x-icon.micro.chevron-right class="text-gray-500"/>
                            </a>
                            <a
                                tabindex="-1"
                                aria-hidden="true"
                                class="text-base font-semibold text-gray-900 transition hover:text-gray-600 dark:text-white dark:hover:text-gray-300"
                                href="{{ route('admin.posts.show', [$story, $nextPost]) }}"
                            >
                                {{ $nextPost->title }}
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="space-y-8 pt-9">
            @if ($post->postType->fields->rating->enabled)
                <div class="flex flex-col gap-y-4">
                    <x-rating.display type="language" :rating="$post->rating_language" size="md" show-details/>
                    <x-rating.display type="sex" :rating="$post->rating_sex" size="md" show-details/>
                    <x-rating.display type="violence" :rating="$post->rating_violence" size="md" show-details/>
                </div>
            @endif

            <div class="space-y-4">
                <x-heading level="3">Authors</x-heading>

                <div class="space-y-2">
                    @foreach ($post->characterAuthors as $characterAuthor)
                        <div
                            class="flex items-center gap-x-2 truncate text-sm/4 font-semibold text-gray-700 dark:text-gray-300"
                        >
                            <x-avatar :src="$characterAuthor->avatar_url" size="sm"/>
                            <div>{{ $characterAuthor->name }}</div>
                        </div>
                    @endforeach

                    @foreach ($post->userAuthors as $userAuthor)
                        <div
                            class="flex items-center gap-x-2 truncate text-sm/4 font-semibold text-gray-700 dark:text-gray-300"
                        >
                            <x-avatar :src="$userAuthor->avatar_url" size="sm"/>
                            <div>{{ $userAuthor->pivot->as ?? $userAuthor->display_name }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if (filled($previousPost))
                <div class="flex flex-col items-start gap-1.5">
                    <a
                        class="inline-flex items-center justify-center gap-0.5 overflow-hidden rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-900 transition hover:bg-gray-200 dark:bg-gray-800/40 dark:text-gray-400 dark:ring-1 dark:ring-gray-800 dark:ring-inset dark:hover:bg-gray-800 dark:hover:text-gray-300 [&>[data-slot=icon]]:-ml-1"
                        aria-label="Previous post: {{ $previousPost->title }}"
                        href="{{ route('admin.posts.show', [$story, $previousPost]) }}"
                    >
                        <x-icon.micro.chevron-left class="text-gray-500"/>
                        <span>Previous</span>
                    </a>
                    <a
                        tabindex="-1"
                        aria-hidden="true"
                        class="text-sm/6 font-semibold text-gray-900 transition hover:text-gray-600 dark:text-white dark:hover:text-gray-300"
                        href="{{ route('admin.posts.show', [$story, $previousPost]) }}"
                    >
                        {{ $previousPost->title }}
                    </a>
                </div>
            @endif

            @if (filled($nextPost))
                <div class="flex flex-col items-start gap-1.5">
                    <a
                        class="inline-flex items-center justify-center gap-0.5 overflow-hidden rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-900 transition hover:bg-gray-200 dark:bg-gray-800/40 dark:text-gray-400 dark:ring-1 dark:ring-gray-800 dark:ring-inset dark:hover:bg-gray-800 dark:hover:text-gray-300 [&>[data-slot=icon]]:-mr-1"
                        aria-label="Next post: {{ $nextPost->title }}"
                        href="{{ route('admin.posts.show', [$story, $nextPost]) }}"
                    >
                        <span>Next</span>
                        <x-icon.micro.chevron-right class="text-gray-500"/>
                    </a>
                    <a
                        tabindex="-1"
                        aria-hidden="true"
                        class="text-sm/6 font-semibold text-gray-900 transition hover:text-gray-600 dark:text-white dark:hover:text-gray-300"
                        href="{{ route('admin.posts.show', [$story, $nextPost]) }}"
                    >
                        {{ $nextPost->title }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
