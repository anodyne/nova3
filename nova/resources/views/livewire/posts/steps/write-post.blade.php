<x-write-post-wizard-layout :steps="$steps">
    <x-content-box>
        <div class="space-y-8">
            <div class="flex items-center space-between">
                <input type="text" wire:model.debounce.1s="post.title" class="block w-full flex-1 appearance-none bg-transparent border-none focus:ring-0 text-3xl font-extrabold placeholder-gray-400 tracking-tight p-0.5" placeholder="Add a title">
            </div>

            @if ($postType->fields->location->enabled || $postType->fields->day->enabled || $postType->fields->time->enabled)
                <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                    @if ($postType->fields->location->enabled)
                        <button type="button" class="flex items-center space-x-1.5 rounded-full text-sm md:text-xs py-1.5 md:py-0.5 px-3 md:px-2 border transition {{ $post->location ? 'bg-primary-50 dark:bg-primary-900/50 border-primary-300 dark:border-primary-800 text-primary-600 dark:text-primary-400' : 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 border-gray-300 dark:border-gray-600 hover:border-gray-500/30 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400' }}" wire:click='$emit("openModal", "posts:select-location-modal", {{ json_encode([$story->id, $post->location]) }})'>
                            @icon('location', 'h-6 w-6 md:h-5 md:w-5 ' . ($post->location ? 'text-primary-500' : 'text-gray-400 dark:text-gray-500'))
                            <span class="font-medium">{{ $post->location ?? 'Add a location' }}</span>
                        </button>
                    @endif

                    @if ($postType->fields->day->enabled)
                        <button type="button" class="flex items-center space-x-1.5 rounded-full text-sm md:text-xs py-1.5 md:py-0.5 px-3 md:px-2 border transition  {{ $post->day ? 'bg-primary-50 dark:bg-primary-900/50 border-primary-300 dark:border-primary-800 text-primary-600 dark:text-primary-400' : 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 border-gray-300 dark:border-gray-600 hover:border-gray-500/30 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400' }}" wire:click='$emit("openModal", "posts:select-day-modal", {{ json_encode([$story->id, $post->day]) }})'>
                            @icon('calendar', 'h-6 w-6 md:h-5 md:w-5 ' . ($post->day ? 'text-primary-500' : 'text-gray-400'))
                            <span class="font-medium">{{ $post->day ?? 'Add a day' }}</span>
                        </button>
                    @endif

                    @if ($postType->fields->time->enabled)
                        <button type="button" class="flex items-center space-x-1.5 rounded-full text-sm md:text-xs py-1.5 md:py-0.5 px-3 md:px-2 border transition  {{ $post->time ? 'bg-primary-50 dark:bg-primary-900/50 border-primary-300 dark:border-primary-800 text-primary-600 dark:text-primary-400' : 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 border-gray-300 dark:border-gray-600 hover:border-gray-500/30 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400' }}" wire:click='$emit("openModal", "posts:select-time-modal", {{ json_encode([$story->id, $post->time]) }})'>
                            @icon('clock', 'h-6 w-6 md:h-5 md:w-5 ' . ($post->time ? 'text-primary-500' : 'text-gray-400'))
                            <span class="font-medium">{{ $post->time ?? 'Add a time' }}</span>
                        </button>
                    @endif
                </div>
            @endif

            <livewire:nova:editor :content="old('post.content', $post->content)" />

            <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                @if ($this->allStories->count() > 1)
                    <button type="button" class="flex items-center space-x-1.5 rounded-full text-sm md:text-xs py-1.5 md:py-0.5 px-3 md:px-2 border transition duration-200 {{ $story ? 'bg-primary-50 hover:bg-primary-100 border-primary-300 hover:border-primary-400 text-primary-600' : 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 border-gray-300 dark:border-gray-600 hover:border-gray-500/30 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400' }}" wire:click='$emit("openModal", "posts:select-story-modal", {{ json_encode([$story->id]) }})'>
                        @icon('book', 'h-6 w-6 md:h-5 md:w-5 shrink-0 ' . ($story ? 'text-primary-500' : 'text-gray-400'))
                        <span class="font-medium">{{ $story->title ?? 'Choose a story' }}</span>
                        <x-icon.chevron-down class="text-primary-500 shrink-0 h-4 w-4" />
                    </button>
                @else
                    <div class="flex items-center space-x-1.5 rounded-full text-sm md:text-xs py-1.5 md:py-0.5 px-3 md:px-2 border transition {{ $story ? 'bg-primary-50 dark:bg-primary-900/50 border-primary-300 dark:border-primary-800 text-primary-600 dark:text-primary-400' : 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 border-gray-300 dark:border-gray-600 hover:border-gray-500/30 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400' }}">
                        @icon('book', 'h-6 w-6 md:h-5 md:w-5 ' . ($story ? 'text-primary-500' : 'text-gray-400'))
                        <span class="font-medium">{{ $story->title ?? 'Choose a story' }}</span>
                    </div>
                @endif

                <button class="flex items-center space-x-1.5 rounded-full text-sm md:text-xs py-1.5 md:py-0.5 px-3 md:px-2 border transition bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 border-gray-300 dark:border-gray-600 hover:border-gray-500/30 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400" wire:click="previousStep">
                    <span style="color:{{ $postType->color }}">@icon($postType->icon, 'h-6 w-6 md:h-5 md:w-5')</span>
                    <span class="font-medium">{{ $postType->name }}</span>
                </button>
            </div>

            @if ($postType->fields->rating->enabled)
                <x-input.group label="Post content ratings">
                    <button type="button" class="appearance-none w-full md:w-1/3" wire:click='$emit("openModal", "posts:set-content-ratings-modal", {{ json_encode(["language" => $ratingLanguage, "sex" => $ratingSex, "violence" => $ratingViolence])  }})'>
                        <div class="space-y-1">
                            <div class="flex items-center space-x-3">
                                <div class="w-20 text-gray-500 text-left font-medium">Language</div>
                                <div class="w-5 font-bold text-gray-900 dark:text-gray-100">{{ $ratingLanguage }}</div>
                                <div class="flex-1">
                                    <div @class([
                                        'rounded-full h-2.5',
                                        'bg-success-500 w-1/4' => $ratingLanguage === 0,
                                        'bg-warning-300 w-1/2' => $ratingLanguage === 1,
                                        'bg-orange-500 w-3/4' => $ratingLanguage === 2,
                                        'bg-error-500 w-full' => $ratingLanguage === 3,
                                    ])></div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-20 text-gray-500 text-left font-medium">Sex</div>
                                <div class="w-5 font-bold text-gray-900 dark:text-gray-100">{{ $ratingSex }}</div>
                                <div class="flex-1">
                                    <div @class([
                                        'rounded-full h-2.5',
                                        'bg-success-500 w-1/4' => $ratingSex === 0,
                                        'bg-warning-300 w-1/2' => $ratingSex === 1,
                                        'bg-orange-500 w-3/4' => $ratingSex === 2,
                                        'bg-error-500 w-full' => $ratingSex === 3,
                                    ])></div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-20 text-gray-500 text-left font-medium">Violence</div>
                                <div class="w-5 font-bold text-gray-900 dark:text-gray-100">{{ $ratingViolence }}</div>
                                <div class="flex-1">
                                    <div @class([
                                        'rounded-full h-2.5',
                                        'bg-success-500 w-1/4' => $ratingViolence === 0,
                                        'bg-warning-300 w-1/2' => $ratingViolence === 1,
                                        'bg-orange-500 w-3/4' => $ratingViolence === 2,
                                        'bg-error-500 w-full' => $ratingViolence === 3,
                                    ])></div>
                                </div>
                            </div>
                        </div>
                    </button>
                </x-input.group>
            @endif

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
                                        <svg viewBox="0 0 12 12" class="w-3 h-3 mr-6 overflow-visible text-primary-500">
                                            <circle cx="6" cy="6" r="6" fill="currentColor"></circle>
                                            <circle cx="6" cy="6" r="11" fill="none" stroke="currentColor" stroke-width="2" class="text-primary-500"></circle>

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
                    <x-input.textarea wire:model.debounce.1s="post.summary" rows="3">{{ old('post.summary', '') }}</x-input.textarea>
                </x-input.group>
            @endif
        </div>
    </x-content-box>

    @if ($this->canSave)
        <x-content-box height="sm" class="flex flex-col space-y-4 rounded-b-lg border-t border-gray-200 dark:border-gray-200/10 md:flex-row-reverse md:items-center md:space-y-0 md:space-x-6 md:space-x-reverse justify-between">
            <div class="flex flex-col md:flex-row-reverse md:items-center md:space-x-reverse space-y-4 md:space-y-0 md:space-x-6">
                <x-button wire:click="goToNextStep" color="primary">Next: Publish Post</x-button>

                <x-button type="button" wire:click="save" color="white">
                    Save
                </x-button>
            </div>

            @can('delete', $post)
                <div>
                    <x-button wire:click="delete" color="gray-error-text" size="none">Discard draft</x-button>
                </div>
            @endcan
        </x-content-box>
    @else
        <x-content-box class="flex justify-end bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-200/10 text-gray-400 dark:text-gray-500 font-medium rounded-b-lg">
            {{ $this->canSaveMessage }}
        </x-content-box>
    @endif
</x-write-post-wizard-layout>
