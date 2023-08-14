<x-write-post-wizard-layout :steps="$steps">
    <div class="mx-auto mt-4 max-w-lg pb-8">
        <div>
            <div>
                <x-h2>Start writing your post</x-h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Choose your post type and the story you're writing in to get started.
                </p>

                <div class="my-6 border-b border-t border-gray-200 py-6 dark:border-gray-700">
                    <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-500">Pick your story</h3>

                    <x-input.select wire:model="storyId" class="mt-4">
                        @foreach ($this->currentStories as $currentStory)
                            <option value="{{ $currentStory->id }}" wire:key="story-{{ $currentStory->id }}">
                                {{ $currentStory->title }}
                            </option>
                        @endforeach
                    </x-input.select>

                    <p class="mt-2 px-1 text-sm text-gray-500">{{ $story?->description }}</p>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-500">Pick a post type</h3>
            <div class="mt-4 space-y-4">
                @forelse ($this->availablePostTypes as $type)
                    {{--
                        <label class="relative block bg-white dark:bg-gray-700 border border-gray-200 dark:border-none rounded-lg shadow-sm dark:shadow-none dark:highlight-white/5 px-4 py-4 cursor-pointer sm:flex sm:justify-between focus:outline-none hover:border-gray-300 dark:hover:bg-gray-600/70 transition" wire:click="setPostType({{ $type }})">
                        <input type="radio" name="post-type" value="{{ $type->id }}" class="sr-only" aria-labelledby="post-type-{{ $type->id }}-label" aria-describedby="post-type-{{ $type->id }}-description-0 post-type-{{ $type->id }}-description-1">
                        <span
                        @class([
                        'flex space-x-3',
                        'items-center' => $postType?->id !== $type->id,
                        ])
                        >
                        @isset($type->icon)
                        <span style="color:{{ $type->color }}">
                        <x-icon :name="$type->icon" size="xl"></x-icon>
                        </span>
                        @else
                        <div class="h-8 w-8"></div>
                        @endif
                        
                        <span class="text-sm flex flex-col">
                        <div class="flex items-center space-x-2" x-data>
                        <span id="post-type-{{ $type->id }}-label" class="text-base font-semibold text-gray-900 dark:text-gray-100">
                        {{ $type->name }}
                        </span>
                        </div>
                        
                        @if ($postType?->id === $type->id)
                        <span id="post-type-{{ $type->id }}-description-0" class="text-gray-500">
                        <p>{{ $type->description }}</p>
                        
                        @if ($type->role)
                        <div class="block mt-1">
                        <x-badge color="gray" class="mt-1">{{ $type->role->display_name }}</x-badge>
                        </div>
                        @endif
                        </span>
                        @endif
                        </span>
                        </span>
                        <span id="post-type-{{ $type->id }}-description-1" class="mt-2 flex sm:items-center sm:mt-0 sm:flex-col sm:ml-4 sm:text-right">
                        @if ($postType?->id === $type->id)
                        <x-icon name="check" size="lg" class="text-primary-500"></x-icon>
                        @endif
                        </span>
                        
                        <span
                        @class([
                        'absolute -inset-px rounded-lg pointer-events-none',
                        'border border-transparent' => $postType?->id !== $type->id,
                        'border-2 border-primary-500' => $postType?->id === $type->id,
                        ])
                        aria-hidden="true"
                        ></span>
                        </label>
                    --}}
                    <div
                        @class([
                            'rounded-lg px-6 py-4',
                            'shadow-md ring-1 ring-inset ring-gray-950/10 dark:bg-gray-800 dark:shadow-lg dark:ring-white/5' => $postType?->id === $type->id,
                            'transition hover:bg-gray-100 dark:hover:bg-gray-800' => $postType?->id !== $type->id,
                        ])
                    >
                        <button
                            type="button"
                            class="flex w-full appearance-none items-center justify-between"
                            wire:click="setPostType({{ $type }})"
                        >
                            <div class="flex items-center gap-2">
                                @isset($type->icon)
                                    @if ($postType?->id === $type->id)
                                        <span style="color: {{ $type->color }}">
                                            <x-icon :name="$type->icon" size="xl"></x-icon>
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-600">
                                            <x-icon :name="$type->icon" size="xl"></x-icon>
                                        </span>
                                    @endif
                                @else
                                    <div class="h-8 w-8"></div>
                                @endif

                                <h3 class="text-left text-base font-semibold text-gray-900 dark:text-white">
                                    {{ $type->name }}
                                </h3>
                            </div>
                            <div class="ml-8 flex shrink-0 items-center space-x-3">
                                @if ($postType?->id !== $type->id)
                                    <x-icon
                                        name="chevron-down"
                                        size="md"
                                        class="text-gray-400 dark:text-gray-500"
                                    ></x-icon>
                                @else
                                    <x-icon
                                        name="chevron-up"
                                        size="md"
                                        class="text-gray-400 dark:text-gray-500"
                                    ></x-icon>
                                @endif
                            </div>
                        </button>

                        @if ($postType?->id === $type->id)
                            <div class="ml-10 mt-2 text-gray-600 dark:text-gray-400">
                                {{ $type->description }}
                            </div>
                        @endif
                    </div>
                @empty
                    <x-empty-state.small
                        icon="edit"
                        title="No post types"
                        message="Create a post type to continue posting"
                        :link="route('post-types.index')"
                        :link-access="gate()->allows('create', Nova\PostTypes\Models\PostType::class)"
                        label="Manage Post Types"
                    ></x-empty-state.small>
                @endforelse
            </div>
        </div>
    </div>

    @if ($postType && $story)
        <x-form.footer>
            <x-button.filled wire:click="goToNextStep">Next: Select authors</x-button.filled>
        </x-form.footer>
    @endif
</x-write-post-wizard-layout>
