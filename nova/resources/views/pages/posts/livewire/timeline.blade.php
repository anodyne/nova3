@if ($stories->count() > 0)
    <x-content-box width="lg">
        <div class="flex items-center gap-8">
            <div class="flex items-center">
                <x-input.select wire:model.numeric.live="storyId">
                    <option value="">Choose a story</option>
                    @foreach ($stories as $story)
                        <option value="{{ $story->id }}">{{ $story->title }}</option>
                    @endforeach
                </x-input.select>
            </div>

            <div class="flex items-center gap-4">
                <x-input.select wire:model.live="sortField">
                    <option value="order_column">Sort chronologically</option>
                    <option value="published_at">Sort by published date</option>
                </x-input.select>

                <div class="flex items-center gap-1">
                    <x-button.text
                        :color="$sortDirection === 'desc' ? 'subtle-neutral' : 'primary'"
                        wire:click="$set('sortDirection', 'asc')"
                    >
                        <x-icon name="sort-descending" size="md"></x-icon>
                    </x-button.text>

                    <x-button.text
                        :color="$sortDirection === 'asc' ? 'subtle-neutral' : 'primary'"
                        wire:click="$set('sortDirection', 'desc')"
                    >
                        <x-icon name="sort-ascending" size="md"></x-icon>
                    </x-button.text>
                </div>
            </div>

            @can('viewAny', $postClass)
                <x-button.filled :href="route('posts.index')" leading="settings" color="primary">
                    Manage posts
                </x-button.filled>
            @endcan
        </div>

        <ul>
            @foreach ($posts as $post)
                <li class="relative flex w-full items-baseline gap-10">
                    <div
                        @class([
                            'before:absolute before:bottom-0 before:left-[5px] before:top-[51px] before:h-full before:w-0.5 before:bg-gray-300 dark:before:bg-gray-700' => ! $loop->last,
                        ])
                    >
                        <div
                            class="z-10 h-3 w-3 rounded-full ring-2 ring-white ring-offset-4 ring-offset-white dark:ring-gray-900 dark:ring-offset-gray-900"
                            style="background-color: {{ $post->postType->color }}"
                        ></div>
                    </div>
                    <div class="flex-1 pt-6">
                        <div class="flex cursor-pointer items-center justify-between gap-6">
                            <div class="flex items-center gap-6">
                                <x-h2>{{ $post->title }}</x-h2>
                            </div>
                        </div>
                        <div class="mt-4 flex-1">
                            <x-content-box width="none" height="none" class="mb-6 flex flex-col gap-6">
                                <div class="flex-1 space-y-4">
                                    <div
                                        class="relative flex flex-col space-y-3 text-base md:flex-row md:items-center md:space-x-8 md:space-y-0 md:text-sm"
                                    >
                                        @if ($post->postType->fields->location->enabled && filled($post->location))
                                            <div
                                                class="flex items-center gap-2 font-medium text-gray-500 dark:text-gray-400"
                                            >
                                                <div class="text-gray-400 dark:text-gray-500">
                                                    <x-icon name="location"></x-icon>
                                                </div>
                                                <div>{{ $post->location }}</div>
                                            </div>
                                        @endif

                                        @if ($post->postType->fields->day->enabled && filled($post->day))
                                            <div
                                                class="flex items-center gap-2 font-medium text-gray-500 dark:text-gray-400"
                                            >
                                                <div class="text-gray-400 dark:text-gray-500">
                                                    <x-icon name="calendar"></x-icon>
                                                </div>
                                                <div>{{ $post->day }}</div>
                                            </div>
                                        @endif

                                        @if ($post->postType->fields->time->enabled && filled($post->time))
                                            <div
                                                class="flex items-center gap-2 font-medium text-gray-500 dark:text-gray-400"
                                            >
                                                <div class="text-gray-400 dark:text-gray-500">
                                                    <x-icon name="clock"></x-icon>
                                                </div>
                                                <div>{{ $post->time }}</div>
                                            </div>
                                        @endif

                                        <div
                                            class="flex items-center gap-2 font-medium text-gray-500 dark:text-gray-400"
                                        >
                                            <div class="text-gray-400 dark:text-gray-500">
                                                <x-icon :name="$post->postType->icon"></x-icon>
                                            </div>
                                            <div>{{ $post->postType->name }}</div>
                                        </div>
                                    </div>

                                    <div class="relative">
                                        <div class="flex -space-x-2 overflow-hidden">
                                            <img
                                                class="inline-block h-10 w-10 rounded-full ring-2 ring-white"
                                                src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                alt=""
                                            />
                                            <img
                                                class="inline-block h-10 w-10 rounded-full ring-2 ring-white"
                                                src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                alt=""
                                            />
                                            <img
                                                class="inline-block h-10 w-10 rounded-full ring-2 ring-white"
                                                src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80"
                                                alt=""
                                            />
                                            <img
                                                class="inline-block h-10 w-10 rounded-full ring-2 ring-white"
                                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                alt=""
                                            />
                                        </div>
                                    </div>

                                    @if ($post->postType->options->showContentInTimelineView)
                                        <div class="prose prose-lg relative max-w-none dark:prose-invert">
                                            {!! $post->content !!}
                                        </div>
                                    @endif

                                    <div class="relative">
                                        <x-button.filled
                                            :href="route('posts.show', ['story' => $post->story, 'post' => $post])"
                                            color="neutral"
                                        >
                                            Read {{ str($post->postType->name)->lower() }} &rarr;
                                        </x-button.filled>
                                    </div>
                                </div>
                            </x-content-box>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </x-content-box>
@else
    <x-empty-state.large
        icon="book"
        title="No posts found"
        :link="route('stories.create')"
        label="Add your first story"
        :link-access="gate()->allows('create', $storyClass)"
    ></x-empty-state.large>
@endif
