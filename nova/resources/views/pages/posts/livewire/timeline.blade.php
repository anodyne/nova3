<x-spacing width="lg">
    <div class="flex items-center gap-x-8">
        <div class="flex items-center">
            <x-select wire:model.numeric.live="storyId" class="text-sm">
                <option value="">Choose a story</option>
                @foreach ($stories as $story)
                    <option value="{{ $story->id }}">{{ $story->title }}</option>
                @endforeach
            </x-select>
        </div>

        <div class="flex items-center">
            <x-input.field>
                <x-slot name="leading">
                    <select
                        aria-label="Post sort field"
                        class="form-select -ml-3 h-full border-none bg-transparent py-0 text-gray-900 focus:shadow-none focus:outline-none focus:ring-0 sm:text-sm dark:text-white"
                        wire:model.live="sortField"
                    >
                        <option value="order_column">Sort by timeline order</option>
                        <option value="published_at">Sort by published date</option>
                    </select>
                </x-slot>

                <select
                    aria-label="Post sort direction"
                    class="form-select -ml-3 h-full border-none bg-transparent py-0 text-gray-900 focus:shadow-none focus:outline-none focus:ring-0 sm:text-sm dark:text-white"
                    wire:model.live="sortDirection"
                >
                    <option value="desc">Newest first</option>
                    <option value="asc">Oldest first</option>
                </select>
            </x-input.field>
        </div>

        @can('viewAny', $postClass)
            <div class="flex items-center">
                <x-button :href="route('posts.index')" color="primary">
                    <x-icon name="settings" size="sm"></x-icon>
                    Manage posts
                </x-button>
            </div>
        @endcan
    </div>

    @if ($posts->count() > 0)
        <x-timeline class="mt-12">
            @foreach ($posts as $post)
                @php
                    $showMetaFields = $post->postType->fields->location->enabled || $post->postType->fields->day->enabled || $post->postType->fields->time->enabled;

                    $showContent = $post->postType->options->showContentInTimelineView;

                    $post->loadMissing('characterAuthors', 'userAuthors');
                @endphp

                <x-timeline.item
                    :title="$post->title"
                    :last="$loop->last"
                    class="ring-white dark:ring-gray-900"
                    style="background-color:{{ $post->postType->color }}"
                >
                    <x-slot name="title">
                        <div class="flex items-center gap-x-6">
                            <x-h2>{{ $post->title }}</x-h2>
                            <x-badge>{{ $post->postType->name }}</x-badge>
                        </div>
                    </x-slot>

                    <div class="mt-1.5">
                        <x-timeline.post-meta-fields :post="$post"></x-timeline.post-meta-fields>

                        @if ($showContent)
                            <div
                                @class([
                                    'prose prose-lg relative max-w-4xl dark:prose-invert',
                                    'mt-4' => $showMetaFields,
                                ])
                            >
                                {!! $post->content !!}
                            </div>
                        @endif

                        <div class="relative mt-4">
                            <div class="flex -space-x-2 overflow-hidden">
                                @foreach ($post->authors_avatars as $url)
                                    <img
                                        class="inline-block h-10 w-10 rounded-full bg-white ring-2 ring-white"
                                        src="{{ $url }}"
                                        alt=""
                                    />
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-timeline.post-meta-data :post="$post"></x-timeline.post-meta-data>
                        </div>

                        <div class="mt-8">
                            <x-button
                                :href="route('posts.show', ['story' => $post->story, 'post' => $post])"
                                color="neutral"
                            >
                                Read {{ str($post->postType->name)->lower() }} &rarr;
                            </x-button>
                        </div>
                    </div>
                </x-timeline.item>
            @endforeach
        </x-timeline>
    @else
        <x-empty-state.large icon="book" title="No posts found">
            <x-slot name="message">
                @if (blank($storyId))
                    Select a story to view the posts timeline
                @else
                    There are no posts in this story
                @endif
            </x-slot>
        </x-empty-state.large>
    @endif
</x-spacing>
