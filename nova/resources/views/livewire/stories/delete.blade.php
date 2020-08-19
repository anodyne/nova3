<div class="space-y-8">
    @foreach ($stories as $story)
        <x-panel>
            <div class="px-4 py-5 | sm:p-6">
                <div class="flex items-start justify-between">
                    <div class="flex flex-col">
                        <h3 class="text-lg font-medium text-gray-900" id="renew-headline">
                            Delete {{ $story->title }}
                        </h3>
                        <div class="mt-2 max-w-xl text-sm text-gray-500">
                            <p id="renew-description">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo totam non cumque deserunt officiis ex maiores nostrum.
                            </p>
                        </div>

                        <div class="mt-8">
                            @if (! $loop->first)
                                @if (data_get($actions, "{$story->id}.story.action") === 'move')
                                    <x-input.group label="Move this story to:">
                                        <select class="form-select" wire:change="trackStoryAction({{ $story->id }}, 'move', $event.target.value)">
                                            <option value="">Choose a story</option>
                                            @foreach ($this->getStoriesForMovingStories($story->id) as $moveStoriesStory)
                                            <option value="{{ $moveStoriesStory->id }}" @if(data_get($actions, "{$story->id}.story.actionId") === $moveStoriesStory->id) selected @endif>{{ $moveStoriesStory->title }}</option>
                                            @endforeach
                                        </select>
                                    </x-input.group>
                                @endif
                            @endif

                            @if (data_get($actions, "{$story->id}.story.action") === 'delete')
                                <x-input.group>
                                    <div class="flex flex-col space-y-6">
                                        <div class="flex flex-col space-y-1">
                                            <x-input.radio
                                                label="Delete this story's posts"
                                                for="delete-posts-{{ $story->id }}"
                                                name="posts_action[{{ $story->id }}]"
                                                id="delete-posts-{{ $story->id }}"
                                                value="delete"
                                                :checked="data_get($actions, $story->id.'.posts.action') === 'delete'"
                                                wire:click="trackPostsAction({{ $story->id }}, 'delete')"
                                            />
                                            <label for="delete-posts-{{ $story->id }}" class="ml-6 max-w-xl text-sm text-gray-500">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur magnam officia sapiente praesentium cum corporis perferendis alias illo qui non consectetur in repellat ipsam assumenda, odio ad! Sunt, harum illo.
                                            </label>
                                        </div>

                                        <div class="flex flex-col space-y-1">
                                            <x-input.radio
                                                label="Move this story's posts"
                                                for="move-posts-{{ $story->id }}"
                                                name="posts_action[{{ $story->id }}]"
                                                id="move-posts-{{ $story->id }}"
                                                value="move"
                                                :checked="data_get($actions, $story->id.'.posts.action') === 'move'"
                                                wire:click="trackPostsAction({{ $story->id }}, 'move')"
                                            />
                                            <label for="move-posts-{{ $story->id }}" class="ml-6 max-w-xl text-sm text-gray-500">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur magnam officia sapiente praesentium cum corporis perferendis alias illo qui non consectetur in repellat ipsam assumenda, odio ad! Sunt, harum illo.
                                            </label>
                                        </div>
                                    </div>
                                </x-input.group>
                            @endif

                            @if (data_get($actions, "{$story->id}.posts.action") === 'move')
                                <x-input.group label="Move this story's posts to:">
                                    <select name="" class="form-select" wire:change="trackPostsAction({{ $story->id }}, 'move', $event.target.value)">
                                        <option value="">Choose a story</option>
                                        @foreach ($this->getStoriesForMovingPosts($story->id) as $movePostsStory)
                                        <option value="{{ $movePostsStory->id }}" @if(data_get($actions, "{$story->id}.posts.actionId") === $movePostsStory->id) selected @endif>{{ $movePostsStory->title }}</option>
                                        @endforeach
                                    </select>
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

    {{-- <x-form.section
        :title="$story->title"
        :message="$story->description"
        x-data="{ storyAction: 'delete', postsAction: 'move' }"
        wire:key="{{ $loop->index }}"
        >
        @if (! $loop->first)
        <x-input.group>
            <x-input.radio
            label="Delete this story"
            for="delete-story-{{ $story->id }}"
            name="story_action[{{ $story->id }}]"
            id="delete-story-{{ $story->id }}"
            value="delete"
            :checked="data_get($actions, $story->id.'.story.action') === 'delete'"
            wire:click="trackStoryAction({{ $story->id }}, 'delete')"
            />

            <span class="ml-6">
                <x-input.radio
                label="Move this story"
                for="move-story-{{ $story->id }}"
                name="story_action[{{ $story->id }}]"
                id="move-story-{{ $story->id }}"
                value="move"
                :checked="data_get($actions, $story->id.'.story.action') === 'move'"
                wire:click="trackStoryAction({{ $story->id }}, 'move')"
                />
            </span>
        </x-input.group>

        @if (data_get($actions, "{$story->id}.story.action") === 'move')
        <x-input.group label="Move this story to:">
            <select class="form-select" wire:change="trackStoryAction({{ $story->id }}, 'move', $event.target.value)">
                <option value="">Choose a story</option>
                @foreach ($this->getStoriesForMovingStories($story->id) as $moveStoriesStory)
                <option value="{{ $moveStoriesStory->id }}" @if(data_get($actions, "{$story->id}.story.actionId") === $moveStoriesStory->id) selected @endif>{{ $moveStoriesStory->title }}</option>
                @endforeach
            </select>
        </x-input.group>
        @endif
        @endif

        @if (data_get($actions, "{$story->id}.story.action") === 'delete')
        <x-input.group>
            <x-input.radio
            label="Delete this story's posts"
            for="delete-posts-{{ $story->id }}"
            name="posts_action[{{ $story->id }}]"
            id="delete-posts-{{ $story->id }}"
            value="delete"
            :checked="data_get($actions, $story->id.'.posts.action') === 'delete'"
            wire:click="trackPostsAction({{ $story->id }}, 'delete')"
            />

            <span class="ml-6">
                <x-input.radio
                label="Move this story's posts"
                for="move-posts-{{ $story->id }}"
                name="posts_action[{{ $story->id }}]"
                id="move-posts-{{ $story->id }}"
                value="move"
                :checked="data_get($actions, $story->id.'.posts.action') === 'move'"
                wire:click="trackPostsAction({{ $story->id }}, 'move')"
                />
            </span>
        </x-input.group>

        @if (data_get($actions, "{$story->id}.posts.action") === 'move')
        <x-input.group label="Move this story's posts to:">
            <select name="" class="form-select" wire:change="trackPostsAction({{ $story->id }}, 'move', $event.target.value)">
                <option value="">Choose a story</option>
                @foreach ($this->getStoriesForMovingPosts($story->id) as $movePostsStory)
                <option value="{{ $movePostsStory->id }}" @if(data_get($actions, "{$story->id}.posts.actionId") === $movePostsStory->id) selected @endif>{{ $movePostsStory->title }}</option>
                @endforeach
            </select>
        </x-input.group>
        @endif
        @endif
    </x-form.section> --}}
    @endforeach

    <input type="hidden" name="actions" value="{{ json_encode($actions) }}">
</div>