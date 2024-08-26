@extends($meta->template)

@section('content')
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

                    <div class="flex items-center gap-x-1.5 text-gray-500">
                        <span>Published</span>
                        <span class="font-medium text-gray-600 dark:text-gray-400">
                            {{ format_date($post->published_at) }}
                        </span>
                    </div>

                    <div class="flex items-center gap-x-1.5 text-gray-500">
                        <span>Reading time</span>
                        <span class="font-medium text-gray-600 dark:text-gray-400">{{ $post->reading_time }}</span>
                    </div>

                    <div class="flex items-center gap-x-1.5 text-gray-500">
                        <span>Words</span>
                        <span class="font-medium text-gray-600 dark:text-gray-400">
                            {{ number_format($post->word_count) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="space-y-8" x-cloak x-show="!showContentWarning">
                @if ($post->postType->fields->showMetaFields())
                    <div
                        class="relative flex flex-col space-y-3 text-lg md:flex-row md:items-center md:space-x-8 md:space-y-0"
                    >
                        @if ($post->postType->fields->location->enabled && filled($post->location))
                            <div class="flex items-center gap-2 font-medium text-gray-600 dark:text-gray-400">
                                <div class="text-gray-400 dark:text-gray-500">
                                    <x-icon name="location" size="lg"></x-icon>
                                </div>
                                <div>{{ $post->location }}</div>
                            </div>
                        @endif

                        @if ($post->postType->fields->day->enabled && filled($post->day))
                            <div class="flex items-center gap-2 font-medium text-gray-600 dark:text-gray-400">
                                <div class="text-gray-400 dark:text-gray-500">
                                    <x-icon name="calendar" size="lg"></x-icon>
                                </div>
                                <div>{{ $post->day }}</div>
                            </div>
                        @endif

                        @if ($post->postType->fields->time->enabled && filled($post->time))
                            <div class="flex items-center gap-2 font-medium text-gray-600 dark:text-gray-400">
                                <div class="text-gray-400 dark:text-gray-500">
                                    <x-icon name="clock" size="lg"></x-icon>
                                </div>
                                <div>{{ $post->time }}</div>
                            </div>
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

                <div class="rounded-md bg-gray-50 ring-1 ring-inset ring-gray-950/5">
                    <x-spacing size="md">
                        <x-h2>{{ str('character')->plural($post->characterAuthors->count())->title() }}</x-h2>

                        <div class="mt-4 grid grid-cols-3 gap-6">
                            @foreach ($post->characterAuthors as $character)
                                <div>
                                    <x-avatar.character :character="$character">
                                        <x-slot name="secondary">by {{ $character->pivot->user?->name }}</x-slot>
                                    </x-avatar.character>
                                </div>
                            @endforeach
                        </div>
                    </x-spacing>

                    <x-spacing size="md">
                        <x-h2>
                            {{ str('author')->plural($post->userAuthors->count())->prepend('Additional ') }}
                        </x-h2>

                        <div class="mt-4 grid grid-cols-3 gap-6">
                            @foreach ($post->userAuthors as $user)
                                <div>
                                    <x-avatar.user :user="$user">
                                        <x-slot name="secondary">as {{ $user->pivot->as }}</x-slot>
                                    </x-avatar.user>
                                </div>
                            @endforeach
                        </div>
                    </x-spacing>
                </div>
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
@endsection
