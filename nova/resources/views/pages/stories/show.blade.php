<x-admin-layout>
    <x-spacing>
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

        <x-page-heading class="mt-6" :heading="$story->title">
            <x-slot name="description">
                <x-metadata.group size="md">
                    <x-metadata label="Status">
                        <x-badge :color="$story->status->getColor()" size="md">
                            {{ $story->status->getLabel() }}
                        </x-badge>
                    </x-metadata>
                </x-metadata.group>
            </x-slot>

            <x-slot name="actions">
                <x-button x-on:click="window.history.back()" variant="ghost">
                    <span aria-hidden="true">←</span>
                    Back
                </x-button>

                @can('update', $story)
                    <x-button :href="route('admin.stories.edit', $story)" variant="primary">
                        <x-icon :name="Tabler::Pencil" size="sm"/>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-heading>

        <x-tab.group>
            <x-slot name="tabs">
                <x-tab name="details">Details</x-tab>
                <x-tab name="posts">Published posts</x-tab>

                @if ($story->has_summary)
                    <x-tab name="summary">Summary</x-tab>
                @endif

                @if ($story->children->count() > 0)
                    <x-tab name="stories">Additional stories</x-tab>
                @endif
            </x-slot>

            <x-tab.panel name="details" class="space-y-12">
                <div class="space-y-4">
                    <div
                        class="prose prose-lg dark:prose-invert prose-a:text-primary-500 hover:prose-a:text-primary-600 dark:hover:prose-a:text-primary-400 max-w-3xl"
                    >
                        {!! $story->description !!}
                    </div>

                    <x-metadata.group gap="lg">
                        @if ($story->started_at)
                            <x-metadata :icon="Tabler::Calendar">
                                @if (blank($story->ended_at))
                                    Started on
                                    @endif

                                    {{ $story->started_at->formatDate() }}
                                    @if ($story->ended_at)
                                        &ndash;
                                    {{ $story->ended_at->formatDate() }}
                                @endif
                            </x-metadata>

                            <x-metadata :icon="Tabler::Clock">
                                @php($daysRunning = $story->started_at->diffInDays($story->ended_at ?? now()))
                                {{ trans_choice('Running for|Ran for', blank($story->ended_at)) }}
                                {{ number_format($daysRunning) }} {{ str('day')->plural($daysRunning) }}
                            </x-metadata>
                        @endif

                        @if ($ancestors->count() > 0)
                            <x-metadata :icon="Tabler::Book2">
                                <a
                                    href="{{ route('admin.stories.show', $ancestors->last()) }}"
                                    class="hover:text-primary-500"
                                >
                                    Part of {{ $ancestors->last()->title }}
                                </a>
                            </x-metadata>
                        @endif
                    </x-metadata.group>
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
            </x-tab.panel>

            <x-tab.panel name="stories">
                <x-stories.timeline :stories="$story->children->loadCount('posts')" expanded></x-stories.timeline>
            </x-tab.panel>

            <x-tab.panel name="posts">
                <livewire:stories-published-posts-list :story="$story"/>
            </x-tab.panel>

            <x-tab.panel
                name="summary"
                class="prose prose-lg dark:prose-invert prose-a:text-primary-500 hover:prose-a:text-primary-600 dark:hover:prose-a:text-primary-400 max-w-none"
            >
                {!! $story->summary !!}
            </x-tab.panel>
        </x-tab.group>
    </x-spacing>
</x-admin-layout>
