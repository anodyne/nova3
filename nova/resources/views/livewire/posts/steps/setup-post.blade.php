<x-write-post-wizard-layout :steps="$steps">
    <div class="max-w-lg mx-auto mt-4 pb-8">
        <div>
            <div>
{{--                @icon('write', 'mx-auto h-12 w-12 text-gray-400')--}}
{{--                <h2 class="mt-2 text-lg font-medium text-gray-900">Start writing your post</h2>--}}
{{--                <p class="mt-1 text-sm text-gray-500">Choose your post type and the story you're writing in to get started.</p>--}}

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Start writing your post</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Choose your post type and the story you're writing in to get started.</p>

                <div class="border-t border-b border-gray-200 dark:border-gray-200/10 my-6 py-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pick your story</h3>

                    <x-input.select wire:model="storyId" class="mt-4">
                        @foreach ($this->allStories as $s)
                            <option value="{{ $s->id }}" wire:key="story-{{ $s->id }}">{{ $s->title }}</option>
                        @endforeach
                    </x-input.select>

                    <p class="text-sm text-gray-500 mt-2 px-1">{{ $story?->description }}</p>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pick a post type</h3>
            <div class="space-y-4 mt-4">
                @forelse ($this->postTypes as $type)
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
                                    @icon($type->icon, 'h-8 w-8')
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
                                @icon('check', 'h-7 w-7 text-primary-500')
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
            <x-button wire:click="nextStep" color="primary">Next: Select Authors</x-button>
        </x-form.footer>
    @endif

    {{--    <x-form action="">--}}
{{--        <x-form.section title="Choose a post type" message="Select the type of post you want to write.">--}}
{{--            <div class="space-y-4">--}}
{{--                @forelse ($this->postTypes as $type)--}}
{{--                    <label class="relative block bg-white dark:bg-gray-700 border border-gray-200 dark:border-none rounded-lg shadow-sm dark:shadow-none dark:highlight-white/5 px-6 py-4 cursor-pointer sm:flex sm:justify-between focus:outline-none hover:border-gray-300 dark:hover:bg-gray-600/70 transition" wire:click="setPostType({{ $type }})">--}}
{{--                        <input type="radio" name="post-type" value="{{ $type->id }}" class="sr-only" aria-labelledby="post-type-{{ $type->id }}-label" aria-describedby="post-type-{{ $type->id }}-description-0 post-type-{{ $type->id }}-description-1">--}}
{{--                        <span class="flex space-x-3">--}}
{{--                            @isset($type->icon)--}}
{{--                                <span style="color:{{ $type->color }}">--}}
{{--                                    @icon($type->icon, 'h-8 w-8')--}}
{{--                                </span>--}}
{{--                            @else--}}
{{--                                <div class="h-8 w-8"></div>--}}
{{--                            @endif--}}

{{--                            <span class="text-sm flex flex-col">--}}
{{--                                <div class="flex items-center space-x-2" x-data>--}}
{{--                                    <span id="post-type-{{ $type->id }}-label" class="text-base font-semibold text-gray-900 dark:text-gray-100">--}}
{{--                                        {{ $type->name }}--}}
{{--                                    </span>--}}
{{--                                </div>--}}

{{--                                <span id="post-type-{{ $type->id }}-description-0" class="text-gray-500">--}}
{{--                                    <p>{{ $type->description }}</p>--}}

{{--                                    @if ($type->role)--}}
{{--                                        <div class="block mt-1">--}}
{{--                                            <x-badge color="gray" class="mt-1">{{ $type->role->display_name }}</x-badge>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                </span>--}}
{{--                            </span>--}}
{{--                        </span>--}}
{{--                        <span id="post-type-{{ $type->id }}-description-1" class="mt-2 flex sm:items-center sm:mt-0 sm:flex-col sm:ml-4 sm:text-right">--}}
{{--                            @if ($postType?->id === $type->id)--}}
{{--                                @icon('check', 'h-7 w-7 text-primary-500')--}}
{{--                            @endif--}}
{{--                        </span>--}}

{{--                        <span--}}
{{--                            @class([--}}
{{--                                'absolute -inset-px rounded-lg pointer-events-none',--}}
{{--                                'border border-transparent' => $postType?->id !== $type->id,--}}
{{--                                'border-2 border-primary-500' => $postType?->id === $type->id,--}}
{{--                            ])--}}
{{--                            aria-hidden="true"--}}
{{--                        ></span>--}}
{{--                    </label>--}}
{{--                @empty--}}
{{--                    <x-empty-state.small--}}
{{--                        icon="edit"--}}
{{--                        title="No post types"--}}
{{--                        message="Create a post type to continue posting"--}}
{{--                        :link="route('post-types.index')"--}}
{{--                        :link-access="gate()->allows('create', Nova\PostTypes\Models\PostType::class)"--}}
{{--                        label="Manage Post Types"--}}
{{--                    ></x-empty-state.small>--}}
{{--                @endforelse--}}
{{--            </div>--}}
{{--        </x-form.section>--}}

{{--        <x-form.section title="Choose a story" message="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab accusantium asperiores, at atque beatae blanditiis corporis dolorem earum eligendi hic ipsam iure, obcaecati odio officia perspiciatis quia quo rem totam." class="{{ !$postType ? 'pb-8' : '' }}">--}}
{{--            <div class="space-y-4">--}}
{{--                @forelse ($this->allStories as $s)--}}
{{--                    <label class="relative block bg-white dark:bg-gray-700 border border-gray-200 dark:border-none rounded-lg shadow-sm dark:shadow-none dark:highlight-white/5 px-6 py-4 cursor-pointer sm:flex sm:justify-between focus:outline-none hover:border-gray-300 dark:hover:bg-gray-600/70 transition" wire:click="setStory({{ $s }})">--}}
{{--                        <input type="radio" name="post-type" value="{{ $s->id }}" class="sr-only" aria-labelledby="post-type-{{ $s->id }}-label" aria-describedby="post-type-{{ $s->id }}-description-0 post-type-{{ $s->id }}-description-1">--}}
{{--                        <span class="flex space-x-3">--}}
{{--                            <span class="text-sm flex flex-col">--}}
{{--                                <span id="post-type-{{ $s->id }}-label" class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ $s->title }}</span>--}}
{{--                                <span id="post-type-{{ $s->id }}-description-0" class="text-gray-500">--}}
{{--                                    <p>{{ $s->description }}</p>--}}
{{--                                </span>--}}
{{--                            </span>--}}
{{--                        </span>--}}
{{--                        <span id="post-type-{{ $s->id }}-description-1" class="mt-2 flex sm:items-center sm:mt-0 sm:flex-col sm:ml-4 sm:text-right">--}}
{{--                            @if ($story?->id === $s->id)--}}
{{--                                @icon('check', 'h-7 w-7 text-primary-500')--}}
{{--                            @endif--}}
{{--                        </span>--}}

{{--                        <span--}}
{{--                            @class([--}}
{{--                                'absolute -inset-px rounded-lg pointer-events-none',--}}
{{--                                'border border-transparent' => $story?->id !== $s->id,--}}
{{--                                'border-2 border-primary-500' => $story?->id === $s->id,--}}
{{--                            ])--}}
{{--                            aria-hidden="true"--}}
{{--                        ></span>--}}
{{--                    </label>--}}
{{--                @empty--}}
{{--                    <x-empty-state.small--}}
{{--                        icon="book"--}}
{{--                        title="No current stories"--}}
{{--                        message="Create a story to continue posting"--}}
{{--                        :link="route('stories.index')"--}}
{{--                        :link-access="gate()->allows('create', Nova\Stories\Models\Story::class)"--}}
{{--                        label="Manage Stories"--}}
{{--                    ></x-empty-state.small>--}}
{{--                @endforelse--}}
{{--            </div>--}}
{{--        </x-form.section>--}}

{{--        @if ($postType && $story)--}}
{{--            <x-form.footer>--}}
{{--                <x-button wire:click="nextStep" color="primary">Next: Select Authors</x-button>--}}
{{--            </x-form.footer>--}}
{{--        @endif--}}
{{--    </x-form>--}}
</x-write-post-wizard-layout>
