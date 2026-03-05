<x-spacing constrained>
    <x-form :action="route('admin.stories.destroy')" method="DELETE">
        @foreach ($stories as $story)
            @php($story->loadMissing('parent'))

            <x-fieldset
                x-data="{
                    storyAction: $wire.entangle('actions.{{ $story->id }}.story.action').live,
                    storyActionId: $wire.entangle('actions.{{ $story->id }}.story.actionId').live,
                    postsAction: $wire.entangle('actions.{{ $story->id }}.posts.action').live,
                    postsActionId: $wire.entangle('actions.{{ $story->id }}.posts.actionId').live,
                }"
                x-init="
                    $watch('storyAction', value => {
                        storyActionId = null;

                        if (value === 'delete') {
                            postsAction = 'delete';
                            postsActionId = null;
                        }

                        if (value === 'move') {
                            postsAction = 'none';
                            postsActionId = null;
                        }
                    });

                    $watch('postsAction', value => postsActionId = null);
                "
            >
                <x-fieldset.group>
                    <x-panel variant="well">
                        <x-panel.header :title="$story->title">
                            @if ($story->parent && ! $loop->first)
                                <x-slot name="description">
                                    This story is nested inside {{ $story->parent->title }}
                                </x-slot>
                            @endif
                        </x-panel.header>

                        <x-panel>
                            <x-spacing size="row">
                                <x-radio.group
                                    x-model="storyAction"
                                    variant="cards"
                                    :disabled="$loop->first"
                                    class="w-full"
                                >
                                    <x-radio value="delete" :indicator="false" :accent="false">
                                        <x-slot name="label">
                                            Delete
                                            <em>{{ $story->title }}</em>
                                        </x-slot>
                                        <x-slot name="icon">
                                            <x-icon :name="Tabler::Trash" size="sm" />
                                        </x-slot>
                                    </x-radio>
                                    <x-radio value="move" :indicator="false" :accent="false">
                                        <x-slot name="label">
                                            Move
                                            <em>{{ $story->title }}</em>
                                        </x-slot>
                                        <x-slot name="icon">
                                            <x-icon :name="Tabler::CircleArrowRight" size="sm" />
                                        </x-slot>
                                    </x-radio>
                                </x-radio.group>

                                <div x-show="storyAction === 'move'" x-cloak class="mt-8">
                                    <x-select name="move_story" label="Move story to" x-model="storyActionId">
                                        <option value="">Choose a story</option>
                                        @foreach ($this->getStoriesForMovingStories($story->id) as $moveStoriesStory)
                                            <option value="{{ $moveStoriesStory->id }}">
                                                {{ $moveStoriesStory->title }}
                                            </option>
                                        @endforeach
                                    </x-select>
                                </div>
                            </x-spacing>

                            <div class="relative">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-200 dark:border-gray-800"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <span
                                        class="bg-white px-4 text-sm font-medium text-gray-600 dark:bg-gray-950 dark:text-gray-300"
                                    >
                                        and
                                    </span>
                                </div>
                            </div>

                            <x-spacing size="row">
                                <div x-show="storyAction === 'delete'" x-cloak>
                                    <x-radio.group x-model="postsAction" variant="cards" class="w-full">
                                        <x-radio value="delete" :indicator="false" :accent="false">
                                            <x-slot name="label">
                                                Delete
                                                {{-- format-ignore-start --}}
                                                <em>{{ $story->title }}</em>’s posts
                                                {{-- format-ignore-end --}}
                                            </x-slot>
                                            <x-slot name="icon">
                                                <x-icon :name="Tabler::Trash" size="sm" />
                                            </x-slot>
                                        </x-radio>
                                        <x-radio value="move" :indicator="false" :accent="false">
                                            <x-slot name="label">
                                                Move
                                                {{-- format-ignore-start --}}
                                                <em>{{ $story->title }}</em>’s posts
                                                {{-- format-ignore-end --}}
                                            </x-slot>
                                            <x-slot name="icon">
                                                <x-icon :name="Tabler::CircleArrowRight" size="sm" />
                                            </x-slot>
                                        </x-radio>
                                    </x-radio.group>

                                    <div x-show="postsAction === 'move'" x-cloak class="mt-8">
                                        <x-select
                                            label="Move this story’s posts to"
                                            name="move_posts"
                                            x-model="postsActionId"
                                        >
                                            <option value="">Choose a story</option>
                                            @foreach ($this->getStoriesForMovingPosts($story->id) as $movePostsStory)
                                                <option value="{{ $movePostsStory->id }}">
                                                    {{ $movePostsStory->title }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2" x-show="storyAction === 'move'" x-cloak>
                                    <x-icon
                                        :name="Tabler::CircleMinus"
                                        size="md"
                                        class="text-gray-500 dark:text-gray-400"
                                    />
                                    <x-heading size="lg" level="4" class="flex-1">
                                        Its story posts will not be updated
                                    </x-heading>
                                </div>
                            </x-spacing>
                        </x-panel>
                    </x-panel>
                </x-fieldset.group>
            </x-fieldset>
        @endforeach

        <input type="hidden" name="actions" value="{{ json_encode($actions) }}" />

        <x-fieldset.controls>
            <x-button type="submit" variant="primary">Delete</x-button>
            <x-button :href="route('admin.stories.index')" variant="ghost">Cancel</x-button>
        </x-fieldset.controls>
    </x-form>
</x-spacing>
