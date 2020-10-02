<div>
    <header class="relative shadow bg-white mb-8">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-4 py-3 | sm:px-6 md:px-8">
            <div class="flex flex-col">
                @if ($postType && $allPostTypes->count() > 1)
                    <x-button wire:click="setPostType()" color="dark-gray-text">
                        @icon('chevron-left', 'h-4 w-4 mr-1')
                        Change post type
                    </x-button>
                @else
                    <x-button-link :href="route('dashboard')" color="dark-gray-text">
                        @icon('chevron-left', 'h-4 w-4 mr-1')
                        <span>Back to Dashboard</span>
                    </x-button-link>
                @endif
            </div>

            <div class="flex items-center space-x-4">
                @if ($postType)
                    <x-button wire:click="save" wire:poll.30s="save" color="white" :disabled="$saving">
                        @if ($saving)
                            Saving...
                        @else
                            Save
                        @endif
                    </x-button>
                    <x-button wire:click="publish" color="blue">Publish</x-button>
                @else
                    Trailing
                @endif
            </div>
        </div>
    </header>

    <main class="w-full max-w-7xl mx-auto px-4 | sm:px-6 md:px-8">
        @if (! $postType)
            @livewire('posts:pick-post-type', [
                'postTypes' => $allPostTypes,
            ])
        @else
            <div class="grid gap-8 | lg:grid-cols-4">
                <div class="lg:col-span-3">
                    <div class="w-full mb-8">
                        @if ($allStories->count() === 1)
                            <p class="text-base font-semibold text-gray-500 mb-2">{{ $allStories->first()->title }}</p>
                        @endif

                        @if ($allStories->count() > 1)
                            <x-dropdown class="text-base font-semibold text-gray-500 mb-2" wide>
                                <x-slot name="trigger">
                                    <div class="inline-flex items-center space-x-1">
                                        <span>{{ $story->title }}</span>
                                        <svg class="h-4 w-4 -mr-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </x-slot>

                                @foreach ($allStories as $selectStory)
                                    <button wire:click="setStory({{ $selectStory->id }})" class="{{ $component->link() }}">{{ $selectStory->title }}</button>
                                @endforeach
                            </x-dropdown>
                        @endif

                        <x-posts.field
                            :field="$postType->fields->title"
                            name="title"
                            :suggestion="$suggestion"
                            :value="$title"
                            wire:model.lazy="title"
                            placeholder="Add your title"
                            class="text-3xl font-extrabold text-gray-900 tracking-tight | sm:text-4xl md:text-5xl"
                            tabindex="1"
                        ></x-posts.field>

                        @if ($postType->fields->time->enabled || $postType->fields->day->enabled || $postType->fields->location->enabled)
                            <div class="flex flex-col space-y-8 text-gray-600 text-lg font-medium mt-8 | md:mt-4 md:flex-row md:items-start md:space-x-8 md:space-y-0">
                                <x-posts.field
                                    :field="$postType->fields->day"
                                    icon="calendar"
                                    name="day"
                                    :suggestion="$suggestion"
                                    :value="$day"
                                    wire:model.lazy="day"
                                    placeholder="Add a day"
                                    tabindex="2"
                                ></x-posts.field>

                                <x-posts.field
                                    :field="$postType->fields->time"
                                    icon="clock"
                                    name="time"
                                    :suggestion="$suggestion"
                                    :value="$time"
                                    wire:model.lazy="time"
                                    placeholder="Add a time"
                                    tabindex="3"
                                ></x-posts.field>

                                <x-posts.field
                                    :field="$postType->fields->location"
                                    icon="location"
                                    name="location"
                                    :suggestion="$suggestion"
                                    :value="$location"
                                    wire:model.lazy="location"
                                    placeholder="Add a location"
                                    tabindex="4"
                                ></x-posts.field>
                            </div>
                        @endif
                    </div>

                    {{-- <x-input.group for="content" label="Content" :error="$errors->first('content')">
                        <x-input.rich-text wire:model.debounce="content" name="content" :initial-value="old('content')" tabindex="5" />
                    </x-input.group> --}}

                    <x-posts.editor
                        :field="$postType->fields->content"
                        name="content"
                        :suggestion="$suggestion"
                        :value="$content"
                        wire:model.debounce="content"
                        tabindex="6"
                    ></x-posts.editor>
                </div>

                <div class="space-y-8">
                    <div class="flex flex-col">
                        <span class="text-xs uppercase tracking-wide font-semibold text-gray-500">Your characters</span>
                        Select your characters
                    </div>

                    @if ($postType->options->multipleAuthors)
                        <div class="flex flex-col">
                            <span class="text-xs uppercase tracking-wide font-semibold text-gray-500">Other characters</span>
                            Add more characters
                        </div>

                        <div class="flex flex-col">
                            <span class="text-xs uppercase tracking-wide font-semibold text-gray-500">Other contributors</span>
                            Add other contributors
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </main>
</div>