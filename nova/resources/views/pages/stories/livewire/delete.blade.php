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
                <x-button :href="route('stories.index')" color="neutral" plain>&larr; Back</x-button>
            @endcan
        </x-slot>
    </x-panel.header>

    <x-form :action="route('stories.destroy')" method="DELETE">
        <x-content-box width="none" height="none">
            <div class="divide-y divide-gray-200 dark:divide-gray-200/20">
                @foreach ($stories as $story)
                    <x-content-box>
                        <div class="flex items-start">
                            <div class="flex flex-col">
                                <div
                                    class="flex items-center gap-x-3 text-lg font-semibold text-gray-900 dark:text-white"
                                    x-data="{}"
                                    x-on:toggle-switch-changed="
                                        $dispatch('deleteStoryToggle', {
                                            value: $event.detail.value,
                                            storyId: {{ $story->id }},
                                        })
                                    "
                                >
                                    <x-switch
                                        name="active"
                                        id="story-{{ $story->id }}"
                                        :value="old('active', data_get($actions, $story->id.'.story.action') === 'delete')"
                                        :disabled="$loop->first"
                                        color="danger"
                                    ></x-switch>
                                    <x-fieldset.label for="story-{{ $story->id }}">
                                        Delete {{ $story->title }}
                                    </x-fieldset.label>
                                </div>

                                @if ($story->parent)
                                    <div class="mt-2">
                                        <x-badge color="gray" size="lg" pill>
                                            This story is nested inside {{ optional($story->parent)->title }}
                                        </x-badge>
                                    </div>
                                @endif

                                <div
                                    class="mt-4 flex max-w-xl items-center space-x-6 font-medium text-gray-600 dark:text-gray-400"
                                >
                                    @if (data_get($actions, "{$story->id}.story.action") === 'move')
                                        <x-badge color="info" size="md">
                                            <x-icon name="arrow-right" size="sm"></x-icon>
                                            <span>Story will be moved</span>
                                        </x-badge>
                                    @endif

                                    @if (data_get($actions, "{$story->id}.story.action") === 'delete')
                                        <x-badge color="danger" size="md">
                                            <x-icon name="trash" size="sm"></x-icon>
                                            <span>Story will be deleted</span>
                                        </x-badge>
                                    @endif

                                    @if (data_get($actions, "{$story->id}.posts.action") === 'move')
                                        <x-badge color="info" size="md">
                                            <x-icon name="arrow-right" size="sm"></x-icon>
                                            <span>Story posts will be moved</span>
                                        </x-badge>
                                    @endif

                                    @if (data_get($actions, "{$story->id}.posts.action") === 'delete')
                                        <x-badge color="danger" size="md">
                                            <x-icon name="trash" size="sm"></x-icon>
                                            <span>Story posts will be deleted</span>
                                        </x-badge>
                                    @endif

                                    @if (data_get($actions, "{$story->id}.posts.action") === 'none')
                                        <x-badge size="md">
                                            <x-icon name="remove" size="sm"></x-icon>
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
                                        <x-radio.group class="w-full max-w-lg">
                                            <x-radio.field>
                                                <x-fieldset.label for="delete-posts-{{ $story->id }}">
                                                    Delete story posts
                                                </x-fieldset.label>
                                                <x-fieldset.description>
                                                    Delete the posts along with the story. This action is permanent and
                                                    cannot be undone!
                                                </x-fieldset.description>
                                                <x-radio
                                                    name="posts_action[{{ $story->id }}]"
                                                    id="delete-posts-{{ $story->id }}"
                                                    value="delete"
                                                    :checked="data_get($actions, $story->id.'.posts.action') === 'delete'"
                                                    wire:click="trackPostsAction({{ $story->id }}, 'delete')"
                                                ></x-radio>
                                            </x-radio.field>

                                            <x-radio.field>
                                                <x-fieldset.label for="move-posts-{{ $story->id }}">
                                                    Move story posts
                                                </x-fieldset.label>
                                                <x-fieldset.description>
                                                    Move the posts in this story to another story. Everything else about
                                                    the posts will remain the same.
                                                </x-fieldset.description>
                                                <x-radio
                                                    name="posts_action[{{ $story->id }}]"
                                                    id="move-posts-{{ $story->id }}"
                                                    value="move"
                                                    :checked="data_get($actions, $story->id.'.posts.action') === 'move'"
                                                    wire:click="trackPostsAction({{ $story->id }}, 'move')"
                                                ></x-radio>
                                            </x-radio.field>
                                        </x-radio.group>
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
            <x-button type="submit" color="primary">Delete</x-button>
            <x-button :href="route('stories.index')" plain>Cancel</x-button>
        </x-form.footer>
    </x-form>
</x-panel>
