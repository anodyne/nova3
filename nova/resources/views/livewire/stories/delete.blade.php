<div class="space-y-8">
    @foreach ($stories as $story)
        <x-panel>
            <div class="px-4 py-5 | sm:p-6">
                <div class="flex items-start justify-between">
                    <div class="flex flex-col">
                        <h3 class="text-lg font-semibold text-gray-900" id="renew-headline">
                            {{ ucfirst(data_get($actions, "{$story->id}.story.action")) }} {{ $story->title }}
                        </h3>
                        <div class="mt-2 max-w-xl text-gray-600 font-medium flex items-center space-x-6">
                            @if (data_get($actions, "{$story->id}.story.action") === 'move')
                                <div class="flex items-center space-x-1 text-purple-600">
                                    @icon('arrow-right-alt', 'h-6 w-6 flex-shrink-0 text-purple-400')
                                    <span>Story will be moved</span>
                                </div>
                            @endif

                            @if (data_get($actions, "{$story->id}.story.action") === 'delete')
                                <div class="flex items-center space-x-1 text-red-600">
                                    @icon('close-alt', 'h-6 w-6 flex-shrink-0 text-red-400')
                                    <span>Story will be deleted</span>
                                </div>
                            @endif

                            @if (data_get($actions, "{$story->id}.posts.action") === 'move')
                                <div class="flex items-center space-x-1 text-purple-600">
                                    @icon('arrow-right-alt', 'h-6 w-6 flex-shrink-0 text-purple-400')
                                    <span>Story posts will be moved</span>
                                </div>
                            @endif

                            @if (data_get($actions, "{$story->id}.posts.action") === 'delete')
                                <div class="flex items-center space-x-1 text-red-600">
                                    @icon('close-alt', 'h-6 w-6 flex-shrink-0 text-red-400')
                                    <span>Story posts will be deleted</span>
                                </div>
                            @endif

                            @if (data_get($actions, "{$story->id}.posts.action") === 'none')
                                <div class="flex items-center space-x-1 text-gray-600">
                                    @icon('remove-alt', 'h-6 w-6 flex-shrink-0 text-gray-400')
                                    <span>Story posts will not be updated</span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-8">
                            @if (! $loop->first)
                                @if (data_get($actions, "{$story->id}.story.action") === 'move')
                                    <x-input.group label="Move this story to:">
                                        <x-input.select wire:change="trackStoryAction({{ $story->id }}, 'move', $event.target.value)">
                                            <option value="">Choose a story</option>
                                            @foreach ($this->getStoriesForMovingStories($story->id) as $moveStoriesStory)
                                                <option value="{{ $moveStoriesStory->id }}" @if(data_get($actions, "{$story->id}.story.actionId") === $moveStoriesStory->id) selected @endif>{{ $moveStoriesStory->title }}</option>
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
                                            <label for="delete-posts-{{ $story->id }}" class="ml-6 max-w-xl text-sm text-gray-600">
                                                Delete the posts along with the story. This action is permanent and cannot be undone!
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
                                            <label for="move-posts-{{ $story->id }}" class="ml-6 max-w-xl text-sm text-gray-600">
                                                Move the posts in this story to another story. Everything else about the posts will remain the same.
                                            </label>
                                        </div>
                                    </div>
                                </x-input.group>
                            @endif

                            @if (data_get($actions, "{$story->id}.posts.action") === 'move')
                                <x-input.group label="Move this story's posts to:">
                                    <x-input.select wire:change="trackPostsAction({{ $story->id }}, 'move', $event.target.value)">
                                        <option value="">Choose a story</option>
                                        @foreach ($this->getStoriesForMovingPosts($story->id) as $movePostsStory)
                                            <option value="{{ $movePostsStory->id }}" @if(data_get($actions, "{$story->id}.posts.actionId") === $movePostsStory->id) selected @endif>{{ $movePostsStory->title }}</option>
                                        @endforeach
                                    </x-input.select>
                                </x-input.group>
                            @endif
                        </div>
                    </div>
                    <div
                        class="sm:ml-6 sm:flex-shrink-0 sm:flex"
                        x-data="{}"
                        x-on:toggle-changed="livewire.emit('delete-story-toggle', $event.detail.value, {{ $story->id }})"
                    >
                        <x-input.toggle
                            field="active"
                            :value="old('active', data_get($actions, $story->id.'.story.action') === 'delete')"
                            :disabled="$loop->first"
                        />
                    </div>
                </div>
            </div>
        </x-panel>
    @endforeach

    <input type="hidden" name="actions" value="{{ json_encode($actions) }}">
</div>
