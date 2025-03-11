@use('Illuminate\Support\Number')
@use('Nova\Foundation\Helpers\DateHelper')

<x-admin-layout>
    <div x-data="{ showContentWarning: @js($post->show_content_warning_for_admin_site) }">
        <x-spacing class="space-y-8">
            <div>
                <div class="flex justify-between gap-x-8">
                    <div>
                        <div class="flex items-baseline gap-x-4">
                            <x-h1>{{ $post->title }}</x-h1>
                            <p class="font-medium text-gray-400 dark:text-gray-600">{{ $story->title }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-x-4">
                        @if ($previousPost)
                            <x-button :href="route('admin.posts.show', [$story, $previousPost])" color="neutral" text>
                                <x-icon name="arrow-left" size="lg"></x-icon>
                            </x-button>
                        @endif

                        @if ($nextPost)
                            <x-button :href="route('admin.posts.show', [$story, $nextPost])" color="neutral" text>
                                <x-icon name="arrow-right" size="lg"></x-icon>
                            </x-button>
                        @endif

                        @can('update', $post)
                            <x-button href="{{ route('admin.posts.edit', $post) }}" color="primary">
                                <x-icon name="edit" size="sm"></x-icon>
                                Edit
                            </x-button>
                        @endcan
                    </div>
                </div>

                <div class="mt-3 flex items-center gap-x-8 text-sm">
                    <div class="flex items-center gap-x-1">
                        <div style="color: {{ $post->postType->color }}">
                            <x-icon :name="$post->postType->icon" size="sm"></x-icon>
                        </div>
                        <span class="font-semibold text-gray-600 dark:text-gray-400">
                            {{ $post->postType->name }}
                        </span>
                    </div>

                    @if ($post->is_published)
                        <x-metadata
                            label="Published"
                            :value="DateHelper::formatDate($post->published_at)"
                        ></x-metadata>
                    @endif

                    <x-metadata label="Reading time" :value="$post->reading_time"></x-metadata>

                    <x-metadata label="Words" :value="Number::format($post->word_count)"></x-metadata>
                </div>
            </div>

            <div class="space-y-8" x-cloak x-show="!showContentWarning">
                @if ($post->postType->fields->showMetaFields())
                    <div
                        class="relative flex flex-col space-y-3 text-lg md:flex-row md:items-center md:space-x-8 md:space-y-0"
                    >
                        @if ($post->postType->fields->location->enabled && filled($post->location))
                            <x-metadata icon="location" :value="$post->location"></x-metadata>
                        @endif

                        @if ($post->postType->fields->day->enabled && filled($post->day))
                            <x-metadata icon="calendar" :value="$post->day"></x-metadata>
                        @endif

                        @if ($post->postType->fields->time->enabled && filled($post->time))
                            <x-metadata icon="clock" :value="$post->time"></x-metadata>
                        @endif
                    </div>
                @endif

                @if ($post->postType->fields->rating->enabled)
                    <div class="flex items-center gap-x-8">
                        <x-rating.display
                            type="language"
                            :rating="$post->rating_language"
                            size="lg"
                            show-details
                        ></x-rating.display>
                        <x-rating.display
                            type="sex"
                            :rating="$post->rating_sex"
                            size="lg"
                            show-details
                        ></x-rating.display>
                        <x-rating.display
                            type="violence"
                            :rating="$post->rating_violence"
                            size="lg"
                            show-details
                        ></x-rating.display>
                    </div>
                @endif

                <div class="prose prose-lg max-w-none dark:prose-invert">
                    {!! $post->content !!}
                </div>

                <x-panel variant="well">
                    <x-panel.header title="Authors"></x-panel.header>

                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                        @if ($post->characterAuthors->count() > 0)
                            <x-spacing size="md">
                                <x-h5>
                                    {{ str('character')->plural($post->characterAuthors->count())->title() }}
                                </x-h5>

                                <div class="mt-4 grid grid-cols-2 gap-4">
                                    @foreach ($post->characterAuthors as $character)
                                        <div>
                                            <x-avatar.character :$character>
                                                <x-slot name="secondary">
                                                    by {{ $character->pivot->user?->name }}
                                                </x-slot>
                                            </x-avatar.character>
                                        </div>
                                    @endforeach
                                </div>
                            </x-spacing>
                        @endif

                        @if ($post->userAuthors->count() > 0)
                            <x-spacing size="md">
                                <x-h5>
                                    {{ str('author')->plural($post->userAuthors->count())->prepend('Additional ') }}
                                </x-h5>

                                <div class="mt-4 grid grid-cols-3 gap-6">
                                    @foreach ($post->userAuthors as $user)
                                        <div>
                                            <x-avatar.user :$user>
                                                <x-slot name="secondary">as {{ $user->pivot->as }}</x-slot>
                                            </x-avatar.user>
                                        </div>
                                    @endforeach
                                </div>
                            </x-spacing>
                        @endif
                    </x-panel>
                </x-panel>
            </div>

            <div class="pb-16" x-show="showContentWarning" x-cloak>
                <div class="flex items-center gap-x-3">
                    <x-icon name="warning" size="xl" class="text-danger-500"></x-icon>
                    <h1 class="block text-4xl font-extrabold leading-loose tracking-tight text-danger-600">Warning</h1>
                </div>

                <div class="prose mb-8 dark:prose-invert">
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

                <x-button type="button" color="neutral" x-on:click="showContentWarning = false">Continue</x-button>

                @if (filled($post->summary))
                    <div class="mt-12 max-w-2xl">
                        <hr class="mb-12 max-w-lg border-gray-200 dark:border-gray-800" />

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
        </x-spacing>
    </div>
</x-admin-layout>
