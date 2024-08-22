<x-spacing constrained>
    <x-page-header>
        <x-slot name="heading">
            Delete
            @choice('story|stories', $stories->count())
        </x-slot>
        <x-slot name="description">
            Manage story deletion and how nested stories and story posts should be handled
        </x-slot>

        <x-slot name="actions">
            @can('viewAny', $stories->first())
                <x-button :href="route('admin.stories.index')" plain>&larr; Back</x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <x-form :action="route('admin.stories.destroy')" method="DELETE">
        @foreach ($stories as $story)
            <x-fieldset
                x-data="{}"
                x-on:toggle-switch-changed="
                    $dispatch('deleteStoryToggle', {
                        value: $event.detail.value,
                        storyId: {{ $story->id }},
                    })
                "
            >
                <x-fieldset.field-group constrained-lg>
                    <x-panel well>
                        <x-spacing size="sm">
                            <x-switch.field>
                                <x-fieldset.label>Delete {{ $story->title }}</x-fieldset.label>
                                @if ($story->parent)
                                    <x-fieldset.description>
                                        This story is nested inside {{ optional($story->parent)->title }}
                                    </x-fieldset.description>
                                @endif

                                <x-switch
                                    name="active"
                                    id="story-{{ $story->id }}"
                                    :value="old('active', data_get($actions, $story->id.'.story.action') === 'delete')"
                                    :disabled="$loop->first"
                                    color="danger"
                                ></x-switch>
                            </x-switch.field>
                        </x-spacing>

                        <x-spacing size="2xs">
                            <x-panel>
                                <x-spacing size="md" class="flex flex-col items-center">
                                    <div class="flex w-full items-center gap-4">
                                        <div class="shrink-0">
                                            @if (data_get($actions, "{$story->id}.story.action") === 'move')
                                                <x-icon name="arrow-right" size="md" class="text-primary-500"></x-icon>
                                            @endif

                                            @if (data_get($actions, "{$story->id}.story.action") === 'delete')
                                                <x-icon name="trash" size="md" class="text-danger-500"></x-icon>
                                            @endif
                                        </div>

                                        @if (data_get($actions, "{$story->id}.story.action") === 'move')
                                            <x-h4 class="flex-1">{{ $story->title }} will be moved to:</x-h4>
                                        @endif

                                        @if (data_get($actions, "{$story->id}.story.action") === 'delete')
                                            <x-h4 class="flex-1">{{ $story->title }} will be deleted</x-h4>
                                        @endif
                                    </div>

                                    @if (data_get($actions, "{$story->id}.story.action") === 'move')
                                        <div
                                            class="ml-12 mt-4 w-full max-w-lg space-y-4 text-sm font-normal text-gray-500"
                                        >
                                            <x-fieldset.field id="move_story" name="move_story">
                                                <x-select
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
                                                </x-select>
                                            </x-fieldset.field>
                                        </div>
                                    @endif
                                </x-spacing>

                                <div class="relative">
                                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                        <div class="w-full border-t border-gray-950/10 dark:border-white/10"></div>
                                    </div>
                                    <div class="relative flex justify-center">
                                        <span
                                            class="bg-white px-4 text-sm font-medium text-gray-600 dark:bg-gray-900 dark:text-gray-400"
                                        >
                                            and
                                        </span>
                                    </div>
                                </div>

                                <x-spacing size="md">
                                    <div class="flex justify-between gap-6">
                                        <div class="flex items-center gap-4">
                                            <div class="shrink-0">
                                                @if (data_get($actions, "{$story->id}.posts.action") === 'move')
                                                    <x-icon
                                                        name="arrow-right"
                                                        size="md"
                                                        class="text-primary-500"
                                                    ></x-icon>
                                                @endif

                                                @if (data_get($actions, "{$story->id}.posts.action") === 'delete')
                                                    <x-icon name="trash" size="md" class="text-danger-500"></x-icon>
                                                @endif

                                                @if (data_get($actions, "{$story->id}.posts.action") === 'none')
                                                    <x-icon name="remove" size="md" class="text-gray-500"></x-icon>
                                                @endif
                                            </div>

                                            @if (data_get($actions, "{$story->id}.posts.action") === 'move')
                                                <x-h4 class="flex-1">Its story posts will be moved</x-h4>
                                            @endif

                                            @if (data_get($actions, "{$story->id}.posts.action") === 'delete')
                                                <x-h4 class="flex-1">Its story posts will be deleted</x-h4>
                                            @endif

                                            @if (data_get($actions, "{$story->id}.posts.action") === 'none')
                                                <x-h4 class="flex-1">Its story posts will not be updated</x-h4>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="ml-10 mt-4 max-w-lg space-y-4 text-sm font-normal text-gray-500">
                                        @if (data_get($actions, "{$story->id}.story.action") === 'delete')
                                            <x-radio.group class="w-full max-w-lg">
                                                <x-radio.field>
                                                    <x-fieldset.label for="delete-posts-{{ $story->id }}">
                                                        Delete story posts
                                                    </x-fieldset.label>
                                                    <x-fieldset.description>
                                                        Delete the posts along with the story. This action is permanent
                                                        and cannot be undone!
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
                                                        Move the posts in this story to another story. Everything else
                                                        about the posts will remain the same.
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
                                            <x-fieldset.field
                                                label="Move this story's posts to:"
                                                id="move_posts"
                                                name="move_posts"
                                            >
                                                <x-select
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
                                                </x-select>
                                            </x-fieldset.field>
                                        @endif
                                    </div>
                                </x-spacing>
                            </x-panel>
                        </x-spacing>
                    </x-panel>
                </x-fieldset.field-group>
            </x-fieldset>
        @endforeach

        <input type="hidden" name="actions" value="{{ json_encode($actions) }}" />

        <x-fieldset.controls>
            <x-button type="submit" color="primary">Delete</x-button>
            <x-button :href="route('admin.stories.index')" plain>Cancel</x-button>
        </x-fieldset.controls>
    </x-form>
</x-spacing>
