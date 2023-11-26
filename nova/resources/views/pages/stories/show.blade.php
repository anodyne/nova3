@extends($meta->template)

@section('content')
    <x-panel class="relative" x-data="tabsList('details')">
        @if ($story->hasMedia('story-image'))
            <img class="h-72 w-full object-cover" src="{{ $story->getFirstMediaUrl('story-image') }}" alt="" />
        @endif

        <x-content-box height="none" class="pt-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <x-h1>{{ $story->title }}</x-h1>

                    <x-badge :color="$story->status->color()">
                        {{ $story->status->displayName() }}
                    </x-badge>
                </div>

                <div class="flex items-center gap-6">
                    <x-button.text x-on:click="window.history.back()" leading="arrow-left" color="neutral">
                        Back
                    </x-button.text>

                    @can('update', $story)
                        <x-button.filled :href="route('stories.edit', $story)" color="primary">Edit</x-button.filled>
                    @endcan
                </div>
            </div>
        </x-content-box>

        <div>
            <x-content-box class="sm:hidden">
                <x-input.select @change="switchTab($event.target.value)" aria-label="Selected tab">
                    <option value="details">Details</option>
                    <option value="posts">Posts</option>

                    @if ($story->has_summary)
                        <option value="summary">Summary</option>
                    @endif

                    @if ($story->children->count() > 0)
                        <option value="stories">Additional stories</option>
                    @endif
                </x-input.select>
            </x-content-box>
            <div class="hidden sm:block">
                <x-content-box height="none" class="border-b border-gray-200 dark:border-gray-800">
                    <nav class="-mb-px flex">
                        <a
                            href="#"
                            class="ml-8 whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition first:ml-0 focus:outline-none"
                            :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('details'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('details') }"
                            x-on:click.prevent="switchTab('details')"
                        >
                            Details
                        </a>

                        <a
                            href="#"
                            class="ml-8 whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition first:ml-0 focus:outline-none"
                            :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('posts'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('posts') }"
                            x-on:click.prevent="switchTab('posts')"
                        >
                            Posts
                        </a>

                        @if ($story->has_summary)
                            <a
                                href="#"
                                class="ml-8 whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition first:ml-0 focus:outline-none"
                                :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('summary'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('summary') }"
                                x-on:click.prevent="switchTab('summary')"
                            >
                                Summary
                            </a>
                        @endif

                        @if ($story->children->count() > 0)
                            <a
                                href="#"
                                class="ml-8 whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition first:ml-0 focus:outline-none"
                                :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('stories'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('stories') }"
                                x-on:click.prevent="switchTab('stories')"
                            >
                                Additional stories
                            </a>
                        @endif
                    </nav>
                </x-content-box>
            </div>
        </div>

        <x-content-box x-show="isTab('details')" class="space-y-12">
            <div class="space-y-4">
                <div
                    class="prose prose-lg max-w-3xl dark:prose-invert prose-a:text-primary-500 hover:prose-a:text-primary-600 dark:hover:prose-a:text-primary-400"
                >
                    {!! $story->description !!}
                </div>

                <div class="flex flex-col space-y-4 md:flex-row md:items-center md:space-x-8 md:space-y-0">
                    @if ($story->started_at)
                        <div
                            class="flex items-center space-x-2 font-medium text-gray-600 dark:text-gray-400 md:text-sm"
                        >
                            <x-icon name="calendar" size="md" class="text-gray-500"></x-icon>
                            <span>
                                @if (blank($story->ended_at))
                                    Started on
                                @endif

                                {{ format_date($story->started_at, false) }}
                                @if ($story->ended_at)
                                    &ndash;
                                    {{ format_date($story->ended_at) }}
                                @endif
                            </span>
                        </div>

                        <div
                            class="flex items-center space-x-2 font-medium text-gray-600 dark:text-gray-400 md:text-sm"
                        >
                            <x-icon name="clock" size="md" class="text-gray-500"></x-icon>
                            <span>
                                @php($daysRunning = $story->started_at->diffInDays($story->ended_at ?? now()))
                                {{ trans_choice('Running for|Ran for', blank($story->ended_at)) }}
                                {{ number_format($daysRunning) }} {{ str('day')->plural($daysRunning) }}
                            </span>
                        </div>
                    @endif

                    @if ($ancestors->count() > 0)
                        <div class="flex items-center">
                            <x-button.text :href="route('stories.show', $ancestors->last())" color="neutral-primary">
                                <div class="flex items-center space-x-2">
                                    <x-icon name="book" size="md" class="shrink-0"></x-icon>
                                    <span>Part of {{ $ancestors->last()->title }}</span>
                                </div>
                            </x-button.text>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4">
                <x-panel.stat label="Total posts" :value="$story->posts_count"></x-panel.stat>
                <x-panel.stat label="Total words" :value="$story->posts_sum_word_count ?? 0"></x-panel.stat>

                @if ($story->children->count() > 0)
                    <x-panel.stat
                        label="Total posts (all stories within)"
                        :value="$story->recursive_posts_count"
                    ></x-panel.stat>
                    <x-panel.stat
                        label="Total words (all stories within)"
                        :value="$story->recursive_posts_sum_word_count"
                    ></x-panel.stat>
                @endif
            </div>
        </x-content-box>

        <x-content-box x-show="isTab('stories')" x-cloak>
            <x-stories.timeline :stories="$story->children->loadCount('posts')" expanded></x-stories.timeline>
        </x-content-box>

        <div x-show="isTab('posts')" x-cloak>
            <livewire:stories-posts-list :story="$story" />
        </div>

        <x-content-box
            x-show="isTab('summary')"
            class="prose prose-lg max-w-none dark:prose-invert prose-a:text-primary-500 hover:prose-a:text-primary-600 dark:hover:prose-a:text-primary-400"
            x-cloak
        >
            {!! $story->summary !!}
        </x-content-box>
    </x-panel>
@endsection
