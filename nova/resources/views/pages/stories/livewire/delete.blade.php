<x-panel>
    <x-panel.header
        title="Delete story"
        message="Manage story deletion and how nested stories and story posts should be handled"
    >
        <x-slot name="title">
            Delete
            @choice('story|stories', $stories->count())
        </x-slot>
        <x-slot name="actions">
            @can('viewAny', $stories->first())
                <x-button.text :href="route('stories.index')" color="neutral" leading="arrow-left">Back</x-button.text>
            @endcan
        </x-slot>
    </x-panel.header>

    <x-form :action="route('stories.destroy')" method="DELETE" :divide="false">
        <x-content-box width="none" height="none">
            <div class="divide-y divide-gray-200 dark:divide-gray-200/20">
                @foreach ($stories as $story)
                    <x-content-box>
                        <div class="flex items-start">
                            <div class="flex flex-col">
                                <div
                                    class="text-lg font-semibold text-gray-900 dark:text-white"
                                    x-data="{}"
                                    x-on:toggle-switch-changed="
                                        $dispatch('deleteStoryToggle', {
                                            value: $event.detail.value,
                                            storyId: {{ $story->id }},
                                        })
                                    "
                                >
                                    <x-switch-toggle
                                        name="active"
                                        :value="old('active', data_get($actions, $story->id.'.story.action') === 'delete')"
                                        :disabled="$loop->first"
                                        color="danger"
                                    >
                                        <span class="text-gray-900 dark:text-white">Delete {{ $story->title }}</span>
                                    </x-switch-toggle>
                                </div>

                                @if ($story->parent)
                                    <div class="mt-1.5 text-sm text-gray-600 dark:text-gray-400">
                                        This story is nested inside
                                        <span class="font-semibold">{{ optional($story->parent)->title }}</span>
                                    </div>
                                @endif

                                <div
                                    class="mt-4 flex max-w-xl items-center space-x-6 font-medium text-gray-600 dark:text-gray-400"
                                >
                                    @if (data_get($actions, "{$story->id}.story.action") === 'move')
                                        <x-badge color="info">
                                            <x-slot name="leadingIcon">
                                                <x-icon name="arrow-right" size="sm" class="shrink-0"></x-icon>
                                            </x-slot>
                                            <span>Story will be moved</span>
                                        </x-badge>
                                    @endif

                                    @if (data_get($actions, "{$story->id}.story.action") === 'delete')
                                        <x-badge color="danger">
                                            <x-slot name="leadingIcon">
                                                <x-icon name="x" size="sm" class="shrink-0"></x-icon>
                                            </x-slot>
                                            <span>Story will be deleted</span>
                                        </x-badge>
                                    @endif

                                    @if (data_get($actions, "{$story->id}.posts.action") === 'move')
                                        <x-badge color="info">
                                            <x-slot name="leadingIcon">
                                                <x-icon name="arrow-right" size="sm" class="shrink-0"></x-icon>
                                            </x-slot>
                                            <span>Story posts will be moved</span>
                                        </x-badge>
                                    @endif

                                    @if (data_get($actions, "{$story->id}.posts.action") === 'delete')
                                        <x-badge color="danger">
                                            <x-slot name="leadingIcon">
                                                <x-icon name="x" size="sm" class="shrink-0"></x-icon>
                                            </x-slot>
                                            <span>Story posts will be deleted</span>
                                        </x-badge>
                                    @endif

                                    @if (data_get($actions, "{$story->id}.posts.action") === 'none')
                                        <x-badge>
                                            <x-slot name="leadingIcon">
                                                <x-icon name="remove" size="sm" class="shrink-0"></x-icon>
                                            </x-slot>
                                            <span>Story posts will not be updated</span>
                                        </x-badge>
                                    @endif
                                </div>

                                <div class="mt-8 flex flex-col gap-6">
                                    @if (! $loop->first)
                                        @if (data_get($actions, "{$story->id}.story.action") === 'move')
                                            <x-input.group label="Move this story to:">
                                                <x-input.select
                                                    wire:change="trackStoryAction({{ $story->id }}, 'move', $event.target.value)"
                                                >
                                                    <option value="">Choose a story</option>
                                                    @foreach ($this->getStoriesForMovingStories($story->id) as $moveStoriesStory)
                                                        <option
                                                            value="{{ $moveStoriesStory->id }}"
                                                            @if(data_get($actions, "{$story->id}.story.actionId") === $moveStoriesStory->id) selected @endif
                                                        >
                                                            {{ $moveStoriesStory->title }}
                                                        </option>
                                                    @endforeach
                                                </x-input.select>
                                            </x-input.group>
                                        @endif
                                    @endif

                                    @if (data_get($actions, "{$story->id}.story.action") === 'delete')
                                        <x-input.group>
                                            <div class="flex flex-col space-y-6">
                                                <div class="flex flex-col space-y-1">
                                                    <x-input.radio
                                                        label="Delete story posts"
                                                        for="delete-posts-{{ $story->id }}"
                                                        name="posts_action[{{ $story->id }}]"
                                                        id="delete-posts-{{ $story->id }}"
                                                        value="delete"
                                                        :checked="data_get($actions, $story->id.'.posts.action') === 'delete'"
                                                        wire:click="trackPostsAction({{ $story->id }}, 'delete')"
                                                    />
                                                    <label
                                                        for="delete-posts-{{ $story->id }}"
                                                        class="ml-7 max-w-xl text-sm text-gray-600 dark:text-gray-400"
                                                    >
                                                        Delete the posts along with the story. This action is permanent
                                                        and cannot be undone!
                                                    </label>
                                                </div>

                                                <div class="flex flex-col space-y-1">
                                                    <x-input.radio
                                                        label="Move story posts"
                                                        for="move-posts-{{ $story->id }}"
                                                        name="posts_action[{{ $story->id }}]"
                                                        id="move-posts-{{ $story->id }}"
                                                        value="move"
                                                        :checked="data_get($actions, $story->id.'.posts.action') === 'move'"
                                                        wire:click="trackPostsAction({{ $story->id }}, 'move')"
                                                    />
                                                    <label
                                                        for="move-posts-{{ $story->id }}"
                                                        class="ml-7 max-w-xl text-sm text-gray-600 dark:text-gray-400"
                                                    >
                                                        Move the posts in this story to another story. Everything else
                                                        about the posts will remain the same.
                                                    </label>
                                                </div>
                                            </div>
                                        </x-input.group>
                                    @endif

                                    @if (data_get($actions, "{$story->id}.posts.action") === 'move')
                                        <x-input.group label="Move this story's posts to:">
                                            <x-input.select
                                                wire:change="trackPostsAction({{ $story->id }}, 'move', $event.target.value)"
                                            >
                                                <option value="">Choose a story</option>
                                                @foreach ($this->getStoriesForMovingPosts($story->id) as $movePostsStory)
                                                    <option
                                                        value="{{ $movePostsStory->id }}"
                                                        @if(data_get($actions, "{$story->id}.posts.actionId") === $movePostsStory->id) selected @endif
                                                    >
                                                        {{ $movePostsStory->title }}
                                                    </option>
                                                @endforeach
                                            </x-input.select>
                                        </x-input.group>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </x-content-box>
                @endforeach

                <input type="hidden" name="actions" value="{{ json_encode($actions) }}" />
            </div>
        </x-content-box>

        <x-form.footer>
            <x-button.filled type="submit" color="primary">Delete</x-button.filled>
            <x-button.filled :href="route('stories.index')" color="neutral">Cancel</x-button.filled>
        </x-form.footer>
    </x-form>
</x-panel>
