<x-write-post-wizard-layout :steps="$steps">
    <x-content-box>
        <div class="space-y-8">
            <div class="flex items-center space-between">
                <input type="text" wire:model="post.title" class="block w-full flex-1 appearance-none bg-transparent border-none focus:ring-0 text-3xl font-extrabold placeholder-gray-400 tracking-tight p-0.5" placeholder="Add a title">

                <div class="flex items-center space-x-1 ml-8">
                    <div class="block">
                        <div class="flex -space-x-2 overflow-hidden">
                            {{-- <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80" alt=""> --}}
                            {{-- <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-600">
                                <span class="text-sm font-medium leading-none text-gray-600 dark:text-gray-300">AB</span>
                            </span>

                            <img class="inline-block h-10 w-10 rounded-full ring-4 ring-white dark:ring-gray-800" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt=""> --}}

                            <x-button color="blue-outline" size="none" class="h-10 w-10 rounded-full ring-4 ring-white dark:ring-gray-800">
                                @icon('user-add', 'h-6 w-6')
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>

            @if ($postType->fields->location->enabled || $postType->fields->day->enabled || $postType->fields->time->enabled)
                <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                    @if ($postType->fields->location->enabled)
                        <button type="button" class="flex items-center space-x-1.5 rounded-full text-sm md:text-xs py-1.5 md:py-0.5 px-3 md:px-2 border transition {{ $post->location ? 'bg-blue-50 dark:bg-blue-900/50 border-blue-300 dark:border-blue-800 text-blue-600 dark:text-blue-400' : 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 border-gray-300 dark:border-gray-600 hover:border-gray-500/30 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400' }}" wire:click='$emit("openModal", "posts:select-location-modal", {{ json_encode([$story->id, $post->location]) }})'>
                            @icon('location', 'h-6 w-6 md:h-5 md:w-5 ' . ($post->location ? 'text-blue-500' : 'text-gray-400 dark:text-gray-500'))
                            <span class="font-medium">{{ $post->location ?? 'Add a location' }}</span>
                        </button>
                    @endif

                    @if ($postType->fields->day->enabled)
                        <button type="button" class="flex items-center space-x-1.5 rounded-full text-sm md:text-xs py-1.5 md:py-0.5 px-3 md:px-2 border transition  {{ $post->day ? 'bg-blue-50 dark:bg-blue-900/50 border-blue-300 dark:border-blue-800 text-blue-600 dark:text-blue-400' : 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 border-gray-300 dark:border-gray-600 hover:border-gray-500/30 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400' }}" wire:click='$emit("openModal", "posts:select-day-modal", {{ json_encode([$story->id, $post->day]) }})'>
                            @icon('calendar', 'h-6 w-6 md:h-5 md:w-5 ' . ($post->day ? 'text-blue-500' : 'text-gray-400'))
                            <span class="font-medium">{{ $post->day ?? 'Add a day' }}</span>
                        </button>
                    @endif

                    @if ($postType->fields->time->enabled)
                        <button type="button" class="flex items-center space-x-1.5 rounded-full text-sm md:text-xs py-1.5 md:py-0.5 px-3 md:px-2 border transition  {{ $post->time ? 'bg-blue-50 dark:bg-blue-900/50 border-blue-300 dark:border-blue-800 text-blue-600 dark:text-blue-400' : 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 border-gray-300 dark:border-gray-600 hover:border-gray-500/30 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400' }}" wire:click='$emit("openModal", "posts:select-time-modal", {{ json_encode([$story->id, $post->time]) }})'>
                            @icon('clock', 'h-6 w-6 md:h-5 md:w-5 ' . ($post->time ? 'text-blue-500' : 'text-gray-400'))
                            <span class="font-medium">{{ $post->time ?? 'Add a time' }}</span>
                        </button>
                    @endif
                </div>
            @endif

            <livewire:nova:editor :content="old('post.content', $post->content)" />

            <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                @if ($allStories->count() > 1)
                    <button type="button" class="flex items-center space-x-1.5 rounded-full text-sm md:text-xs py-1.5 md:py-0.5 px-3 md:px-2 border transition duration-200 {{ $story ? 'bg-blue-50 hover:bg-blue-100 border-blue-300 hover:border-blue-400 text-blue-600' : 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 border-gray-300 dark:border-gray-600 hover:border-gray-500/30 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400' }}" wire:click='$emit("openModal", "posts:select-story-modal", {{ json_encode([$story->id]) }})'>
                        @icon('book', 'h-6 w-6 md:h-5 md:w-5 shrink-0 ' . ($story ? 'text-blue-500' : 'text-gray-400'))
                        <span class="font-medium">{{ $story->title ?? 'Choose a story' }}</span>
                        <x-icon.chevron-down class="text-blue-500 shrink-0 h-4 w-4" />
                    </button>
                @else
                    <div class="flex items-center space-x-1.5 rounded-full text-sm md:text-xs py-1.5 md:py-0.5 px-3 md:px-2 border transition {{ $story ? 'bg-blue-50 dark:bg-blue-900/50 border-blue-300 dark:border-blue-800 text-blue-600 dark:text-blue-400' : 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 border-gray-300 dark:border-gray-600 hover:border-gray-500/30 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400' }}">
                        @icon('book', 'h-6 w-6 md:h-5 md:w-5 ' . ($story ? 'text-blue-500' : 'text-gray-400'))
                        <span class="font-medium">{{ $story->title ?? 'Choose a story' }}</span>
                    </div>
                @endif

                <button class="flex items-center space-x-1.5 rounded-full text-sm md:text-xs py-1.5 md:py-0.5 px-3 md:px-2 border transition bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 border-gray-300 dark:border-gray-600 hover:border-gray-500/30 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400" wire:click="previousStep">
                    <span style="color:{{ $postType->color }}">@icon($postType->icon, 'h-6 w-6 md:h-5 md:w-5')</span>
                    <span class="font-medium">{{ $postType->name }}</span>
                </button>

                @if ($postType->fields->rating->enabled)
                    <button type="button" class="flex items-center space-x-1.5 rounded-full text-sm md:text-xs py-1.5 md:py-0.5 px-3 md:px-2 border transition  {{ $post->time ? 'bg-blue-50 dark:bg-blue-900/50 border-blue-300 dark:border-blue-800 text-blue-600 dark:text-blue-400' : 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 border-gray-300 dark:border-gray-600 hover:border-gray-500/30 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400' }}" wire:click='$emit("openModal", "posts:set-content-ratings-modal")'>
                        @icon('mature', 'h-6 w-6 md:h-5 md:w-5 ' . ($post->time ? 'text-blue-500' : 'text-gray-400'))
                        <span class="font-medium">Set content ratings</span>
                    </button>
                @endif
            </div>

            {{-- @if ($this->showPostPositionControl)
                <x-input.group label="Post position">
                    <ul class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-none dark:highlight-white/5 rounded-lg w-full md:w-2/3">
                        @if ($previousPost)
                            <li>
                                <article>
                                    <a href="#" class="grid items-start relative rounded-md p-3 sm:p-5 overflow-hidden hover:bg-white dark:hover:bg-gray-900 transition ease-in-out duration-200" wire:click.prevent='$emit("openModal", "posts:read-post-modal", {{ json_encode([$previousPost->id]) }})'>
                                        <div class="md:col-start-1 row-start-1 md:row-end-3 flex items-baseline font-medium mb-1 md:mb-0">
                                            <svg viewBox="0 0 12 12" class="w-3 h-3 mr-6 overflow-visible text-gray-400 dark:text-gray-500">
                                                <circle cx="6" cy="6" r="6" fill="currentColor"></circle>
                                                <path d="M 6 18 V 500" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-400 dark:text-gray-500"></path>
                                            </svg>
                                            <div class="flex flex-col space-y-1 items-start">
                                                <div class="text-gray-900 dark:text-gray-100">{{ $previousPost->title }}</div>

                                                @if ($previousPost->location || $previousPost->day || $previousPost->time)
                                                    <div class="flex items-center space-x-6">
                                                        @if ($previousPost->location)
                                                            <div class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                                                @icon('location', 'h-5 w-5 text-gray-400 dark:text-gray-500 shrink-0')
                                                                <span>{{ $previousPost->location }}</span>
                                                            </div>
                                                        @endif

                                                        @if ($previousPost->day)
                                                            <div class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                                                @icon('calendar', 'h-5 w-5 text-gray-400 dark:text-gray-500 shrink-0')
                                                                <span>{{ $previousPost->day }}</span>
                                                            </div>
                                                        @endif

                                                        @if ($previousPost->time)
                                                            <div class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                                                @icon('clock', 'h-5 w-5 text-gray-400 dark:text-gray-500 shrink-0')
                                                                <span>{{ $previousPost->time }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </article>
                            </li>
                        @endif

                        <li>
                            <article>
                                <button type="button" class="group w-full grid items-start relative rounded-md p-3 sm:p-5 overflow-hidden hover:bg-white dark:hover:bg-gray-900 transition">
                                    <div class="md:col-start-1 row-start-1 md:row-end-3 flex items-center font-medium mb-1 md:mb-0">
                                        <svg viewBox="0 0 12 12" class="w-3 h-3 mr-6 overflow-visible text-blue-500">
                                            <circle cx="6" cy="6" r="6" fill="currentColor"></circle>
                                            <circle cx="6" cy="6" r="11" fill="none" stroke="currentColor" stroke-width="2" class="text-blue-500"></circle>

                                            @if ($previousPost)
                                                <path d="M 6 -6 V -30" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-400 dark:text-gray-500"></path>
                                            @endif

                                            @if ($nextPost)
                                                <path d="M 6 18 V 500" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-400 dark:text-gray-500"></path>
                                            @endif
                                        </svg>
                                        <span class="text-gray-900 dark:text-gray-100 font-bold">{{ $title ?? 'This ' . strtolower($postType->name) }}</span>
                                        <div class="inline-flex items-center space-x-1 invisible group-hover:visible text-sm text-gray-400 ml-12">
                                            @icon('arrow-sort', 'h-5 w-5 text-gray-400 shrink-0')
                                            <span>Change post position</span>
                                        </div>
                                    </div>
                                </button>
                            </article>
                        </li>

                        @if ($nextPost)
                            <li>
                                <article>
                                    <a href="#" class="grid items-start relative rounded-md p-3 sm:p-5 overflow-hidden hover:bg-white transition" wire:click.prevent='$emit("openModal", "posts:read-post-modal", {{ json_encode([$nextPost->id]) }})'>
                                        <div class="md:col-start-1 row-start-1 md:row-end-3 flex items-baseline font-medium mb-1 md:mb-0">
                                            <svg viewBox="0 0 12 12" class="w-3 h-3 mr-6 overflow-visible text-gray-400">
                                                <circle cx="6" cy="6" r="6" fill="currentColor"></circle>
                                                <path d="M 6 -6 V -30" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-400"></path>
                                            </svg>
                                            <div class="flex flex-col space-y-1 items-start">
                                                <div class="text-gray-900">{{ $nextPost->title }}</div>

                                                @if ($nextPost->location || $nextPost->day || $nextPost->time)
                                                    <div class="flex items-center space-x-6">
                                                        @if ($nextPost->location)
                                                            <div class="flex items-center space-x-1 text-sm text-gray-600">
                                                                @icon('location', 'h-5 w-5 text-gray-400 shrink-0')
                                                                <span>{{ $nextPost->location }}</span>
                                                            </div>
                                                        @endif

                                                        @if ($nextPost->day)
                                                            <div class="flex items-center space-x-1 text-sm text-gray-600">
                                                                @icon('calendar', 'h-5 w-5 text-gray-400 shrink-0')
                                                                <span>{{ $nextPost->day }}</span>
                                                            </div>
                                                        @endif

                                                        @if ($nextPost->time)
                                                            <div class="flex items-center space-x-1 text-sm text-gray-600">
                                                                @icon('clock', 'h-5 w-5 text-gray-400 shrink-0')
                                                                <span>{{ $nextPost->time }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </article>
                            </li>
                        @endif
                    </ul>
                </x-input.group>
            @endif --}}

            @if ($postType->fields->summary->enabled)
                <x-input.group label="Post Summary" help="If your post contains content intended only for mature audiences or that could be difficult for some people to read, you can provide a summary of the post." class="w-full md:w-2/3">
                    <x-input.textarea rows="3">{{ old('post.summary', '') }}</x-input.textarea>
                </x-input.group>
            @endif
        </div>
    </x-content-box>

    @if ($this->canSave)
        <x-content-box height="sm" class="flex flex-col space-y-4 rounded-b-lg border-t border-gray-200 dark:border-gray-200/10 md:flex-row-reverse md:items-center md:space-y-0 md:space-x-6 md:space-x-reverse justify-between">
            <div class="flex flex-col md:flex-row-reverse md:items-center md:space-x-reverse space-y-4 md:space-y-0 md:space-x-6">
                <x-button wire:click="nextStep" color="blue">Publish</x-button>

                <x-button wire:click="save" color="white">
                    Save
                </x-button>
            </div>

            @can('delete', $post)
                <div>
                    <x-button wire:click="delete" color="gray-red-text" size="none">Discard draft</x-button>
                </div>
            @endcan
        </x-content-box>
    @else
        <x-content-box class="flex justify-end bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-200/10 text-gray-400 dark:text-gray-500 font-medium rounded-b-lg">
            {{ $this->canSaveMessage }}
        </x-content-box>
    @endif
</x-write-post-wizard-layout>