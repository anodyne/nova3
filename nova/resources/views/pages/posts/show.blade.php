@use('Illuminate\Support\Number')
@use('Nova\Foundation\Helpers\DateHelper')

<x-admin-layout>
    <div x-data="{ showContentWarning: @js($post->show_content_warning) }">
        <x-spacing class="space-y-8" constrained-lg>
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

            <div class="p-16 text-center" x-show="showContentWarning" x-cloak>
                <div class="flex items-center justify-center space-x-4">
                    <x-icon name="warning" size="xl" class="text-danger-500"></x-icon>
                    <h1 class="block text-4xl font-extrabold leading-loose tracking-tight text-danger-600">Warning</h1>
                    <x-icon name="warning" size="xl" class="text-danger-500"></x-icon>
                </div>

                <p class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                    This post contains mature content that may not be suitable for all audiences.
                </p>

                <ul class="mb-4 space-y-2 font-medium text-gray-600 dark:text-gray-400">
                    @if ($post->rating_language >= settings('ratings.language.warning_threshold'))
                        <li>{{ settings('ratings.language.warning_threshold_message') }}</li>
                    @endif

                    @if ($post->rating_sex >= settings('ratings.sex.warning_threshold'))
                        <li>{{ settings('ratings.sex.warning_threshold_message') }}</li>
                    @endif

                    @if ($post->rating_violence >= settings('ratings.violence.warning_threshold'))
                        <li>{{ settings('ratings.violence.warning_threshold_message') }}</li>
                    @endif
                </ul>

                <p class="mb-8 text-sm font-medium text-gray-600 dark:text-gray-400">
                    By continuing, you agree that you are of suitable age for this content.
                </p>

                <x-button type="button" color="neutral" x-on:click="showContentWarning = false">Continue</x-button>

                @if (filled($post->summary))
                    <div class="mx-auto mt-12 max-w-2xl">
                        <hr class="mx-auto mb-12 max-w-lg border-gray-200 dark:border-gray-800" />

                        <x-h3 class="text-left">
                            The following summary has been provided for this {{ str($post->postType->name)->lower() }}:
                        </x-h3>

                        <p class="mt-4 text-left text-base/8">{{ $post->summary }}</p>
                    </div>
                @endif
            </div>
        </x-spacing>
    </div>
</x-admin-layout>
