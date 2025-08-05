@use('Nova\Foundation\Helpers\DateHelper')

<x-admin-layout>
    <x-spacing class="relative" x-data="tabsList('details')">
        @if ($story->hasMedia('story-image'))
            <x-panel variant="well">
                <x-panel variant="inset">
                    <img
                        src="{{ $story->getFirstMediaUrl('story-image') }}"
                        alt=""
                        class="max-h-96 w-full rounded-lg object-cover"
                    />
                </x-panel>
            </x-panel>
        @endif

        <x-page-header class="mt-6" :heading="$story->title">
            <x-slot name="description">
                <x-badge :color="$story->status->getColor()" size="md">
                    {{ $story->status->getLabel() }}
                </x-badge>
            </x-slot>

            <x-slot name="actions">
                <x-button x-on:click="window.history.back()" plain>&larr; Back</x-button>

                @can('update', $story)
                    <x-button :href="route('admin.stories.edit', $story)" color="primary">
                        <x-icon :name="Icon::Edit" size="sm"></x-icon>
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
                    class="prose prose-lg dark:prose-invert prose-a:text-primary-500 hover:prose-a:text-primary-600 dark:hover:prose-a:text-primary-400 max-w-3xl"
                >
                    {!! $story->description !!}
                </div>

                <div class="flex flex-col space-y-4 text-sm/6 md:flex-row md:items-center md:space-y-0 md:space-x-8">
                    @if ($story->started_at)
                        <x-metadata :icon="Icon::Calendar">
                            @if (blank($story->ended_at))
                                Started on
                            @endif

                            {{ DateHelper::formatDate($story->started_at) }}
                            @if ($story->ended_at)
                                &ndash;
                                {{ DateHelper::formatDate($story->ended_at) }}
                            @endif
                        </x-metadata>

                        <x-metadata :icon="Icon::Clock">
                            @php($daysRunning = $story->started_at->diffInDays($story->ended_at ?? now()))
                            {{ trans_choice('Running for|Ran for', blank($story->ended_at)) }}
                            {{ number_format($daysRunning) }} {{ str('day')->plural($daysRunning) }}
                        </x-metadata>
                    @endif

                    @if ($ancestors->count() > 0)
                        <x-metadata :icon="Icon::BookClosed">
                            <a
                                href="{{ route('admin.stories.show', $ancestors->last()) }}"
                                class="hover:text-primary-500"
                            >
                                Part of {{ $ancestors->last()->title }}
                            </a>
                        </x-metadata>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4">
                <x-panel.stat label="Total posts" :value="$story->posts_count"></x-panel.stat>
                <x-panel.stat label="Total words" :value="$story->posts_sum_word_count ?? 0"></x-panel.stat>

                @mysql
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
                @endmysql
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
            class="prose prose-lg dark:prose-invert prose-a:text-primary-500 hover:prose-a:text-primary-600 dark:hover:prose-a:text-primary-400 max-w-none"
            x-cloak
        >
            {!! $story->summary !!}
        </x-spacing>
    </x-spacing>
</x-admin-layout>
