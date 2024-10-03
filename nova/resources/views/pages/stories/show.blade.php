<x-admin-layout>
    <x-spacing class="relative" x-data="tabsList('details')">
        @if ($story->hasMedia('story-image'))
            <div class="rounded-2xl bg-gray-900/5 p-2 ring-1 ring-inset ring-gray-900/10">
                <img
                    src="{{ $story->getFirstMediaUrl('story-image') }}"
                    alt=""
                    class="max-h-96 w-full rounded-lg object-cover shadow-2xl ring-1 ring-gray-900/10"
                />
            </div>
        @endif

        <x-page-header class="mt-6" :heading="$story->title">
            <x-slot name="description">
                <x-badge :color="$story->status->color()" size="md">
                    {{ $story->status->displayName() }}
                </x-badge>
            </x-slot>

            <x-slot name="actions">
                <x-button x-on:click="window.history.back()" plain>&larr; Back</x-button>

                @can('update', $story)
                    <x-button :href="route('admin.stories.edit', $story)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-tab.group name="story">
            <x-tab.heading name="details">Details</x-tab.heading>
            <x-tab.heading name="posts">Posts</x-tab.heading>

            @if ($story->has_summary)
                <x-tab.heading name="summary">Summary</x-tab.heading>
            @endif

            @if ($story->children->count() > 0)
                <x-tab.heading name="stories">Additional stories</x-tab.heading>
            @endif
        </x-tab.group>

        <x-spacing height="xl" width="2xs" x-show="isTab('details')" class="space-y-12">
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
                            <x-button
                                :href="route('admin.stories.show', $ancestors->last())"
                                color="neutral-primary"
                                text
                            >
                                <x-icon name="book" size="md"></x-icon>
                                <span>Part of {{ $ancestors->last()->title }}</span>
                            </x-button>
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
        </x-spacing>

        <x-spacing size="md" x-show="isTab('stories')" x-cloak>
            <x-stories.timeline :stories="$story->children->loadCount('posts')" expanded></x-stories.timeline>
        </x-spacing>

        <div x-show="isTab('posts')" x-cloak>
            <livewire:stories-posts-list :story="$story" />
        </div>

        <x-spacing
            size="md"
            x-show="isTab('summary')"
            class="prose prose-lg max-w-none dark:prose-invert prose-a:text-primary-500 hover:prose-a:text-primary-600 dark:hover:prose-a:text-primary-400"
            x-cloak
        >
            {!! $story->summary !!}
        </x-spacing>
    </x-spacing>
</x-admin-layout>
