{{--
    <x-panel>
    <x-form action="">
    <x-form.section title="Story" message="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur autem sapiente, eum exercitationem ullam debitis doloremque necessitatibus tempora quasi possimus quaerat asperiores repellat ab nulla pariatur non nisi voluptatibus. Commodi!">
    <div class="w-full">
    <x-input.select>
    @foreach ($allStories as $selectStory)
    <option value="{{ $selectStory->id }}">{{ $selectStory->title }}</option>
    @endforeach
    </x-input.select>
    </div>
    </x-form.section>
    
    <x-form.section title="Post Info" message="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur autem sapiente, eum exercitationem ullam debitis doloremque necessitatibus tempora quasi possimus quaerat asperiores repellat ab nulla pariatur non nisi voluptatibus. Commodi!">
    <x-posts.field
    :field="$postType->fields->title"
    name="title"
    :suggestion="$suggestion"
    :value="$title"
    wire:model.lazy="title"
    placeholder="Add your title"
    tabindex="1"
    class="w-2/3"
    ></x-posts.field>
    
    <x-posts.field
    :field="$postType->fields->day"
    icon="calendar"
    name="day"
    :suggestion="$suggestion"
    :value="$day"
    wire:model.lazy="day"
    placeholder="Add a day"
    tabindex="2"
    class="w-2/3"
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
    class="w-2/3"
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
    class="w-2/3"
    ></x-posts.field>
    </x-form.section>
    
    <x-form.section title="Author(s)" message="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur autem sapiente, eum exercitationem ullam debitis doloremque necessitatibus tempora quasi possimus quaerat asperiores repellat ab nulla pariatur non nisi voluptatibus. Commodi!">
    <x-input.group label="Your character(s)">
    Select your character(s)
    </x-input.group>
    
    @if ($postType->options->allowsMultipleAuthors)
    <x-input.group label="Other characters">
    Add more characters
    </x-input.group>
    
    <x-input.group label="Other contributors">
    Add other contributors
    </x-input.group>
    @endif
    </x-form.section>
    
    <x-form.section>
    @livewire('nova:editor', ['content' => $content])
    </x-form.section>
    
    <x-form.section title="Ratings">
    <x-slot:message>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia quam eius provident ex modi nam, at ullam quia labore similique.</p>
    
    <p><strong>Note:</strong> Your post's ratings will match the game's overall ratings until you change them for this post.</p>
    </x-slot:message>
    
    <x-input.group label="Language" class="w-72">
    <x-rating :value="1" wire:model="ratingLanguage" />
    </x-input.group>
    
    <x-input.group label="Sex" class="w-72">
    <x-rating :value="1" name="ratings_sex" />
    </x-input.group>
    
    <x-input.group label="Violence" class="w-72">
    <x-rating :value="3" name="ratings_violence" />
    </x-input.group>
    </x-form.section>
    
    <x-form.footer>
    <x-button.filled wire:click="publish" color="primary">Publish</x-button.filled>
    
    <x-button.filled wire:click="save" wire:poll.30s="save" color="gray">
    Save
    </x-button.filled>
    
    <div class="text-gray-40000" wire:loading.delay>Saving...</div>
    </x-form.footer>
    </x-form>
    </x-panel>
--}}

<x-panel>
    <x-content-box>
        <div class="space-y-8">
            <div class="space-between flex items-center">
                <input
                    type="text"
                    wire:model="title"
                    class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 text-3xl font-extrabold tracking-tight placeholder-gray-400 focus:ring-0"
                    placeholder="Add a title"
                />

                <div class="ml-8 flex items-center space-x-1">
                    <div class="block">
                        <div class="flex -space-x-2 overflow-hidden">
                            {{--
                                <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80" alt="">
                            --}}
                            <span
                                class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-600"
                            >
                                <span class="text-sm font-medium leading-none text-gray-600 dark:text-gray-300">
                                    AB
                                </span>
                            </span>

                            <img
                                class="inline-block h-10 w-10 rounded-full ring-4 ring-white dark:ring-gray-800"
                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt=""
                            />

                            <x-button.filled
                                color="primary"
                                class="h-10 w-10 rounded-full ring-4 ring-white dark:ring-gray-800"
                            >
                                @icon('user-add', 'h-6 w-6')
                            </x-button.filled>
                        </div>
                    </div>
                </div>
            </div>

            @if ($postType->fields->location->enabled || $postType->fields->day->enabled || $postType->fields->time->enabled)
                <div class="flex flex-col space-y-4 md:flex-row md:items-center md:space-x-4 md:space-y-0">
                    @if ($postType->fields->location->enabled)
                        <button
                            type="button"
                            class="{{ $location ? 'border-primary-300 bg-primary-50 text-primary-600 dark:border-primary-600 dark:bg-primary-800 dark:text-primary-400' : 'border-gray-300 bg-white text-gray-500 hover:border-gray-500/30 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-900' }} flex items-center space-x-1.5 rounded-full border px-3 py-1.5 text-sm transition md:px-2 md:py-0.5 md:text-xs"
                            wire:click='$emit("openModal", "posts:select-location-modal", {{ json_encode([$story->id, $location]) }})'
                        >
                            @icon('location', 'h-6 w-6 md:h-5 md:w-5 ' . ($location ? 'text-primary-500' : 'text-gray-400 dark:text-gray-500'))
                            <span class="font-medium">{{ $location ?? 'Add a location' }}</span>
                        </button>
                    @endif

                    @if ($postType->fields->day->enabled)
                        <button
                            type="button"
                            class="{{ $day ? 'border-primary-300 bg-primary-50 text-primary-600 hover:border-primary-400 hover:bg-primary-100' : 'border-gray-300 bg-white text-gray-500 hover:border-gray-500/30 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-900' }} flex items-center space-x-1.5 rounded-full border px-3 py-1.5 text-sm transition md:px-2 md:py-0.5 md:text-xs"
                            wire:click='$emit("openModal", "posts:select-day-modal", {{ json_encode([$story->id, $day]) }})'
                        >
                            @icon('calendar', 'h-6 w-6 md:h-5 md:w-5 ' . ($day ? 'text-primary-500' : 'text-gray-400'))
                            <span class="font-medium">{{ $day ?? 'Add a day' }}</span>
                        </button>
                    @endif

                    @if ($postType->fields->time->enabled)
                        <button
                            type="button"
                            class="{{ $time ? 'border-primary-300 bg-primary-50 text-primary-600 hover:border-primary-400 hover:bg-primary-100' : 'border-gray-300 bg-white text-gray-500 hover:border-gray-500/30 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-900' }} flex items-center space-x-1.5 rounded-full border px-3 py-1.5 text-sm transition md:px-2 md:py-0.5 md:text-xs"
                            wire:click='$emit("openModal", "posts:select-time-modal", {{ json_encode([$story->id, $time]) }})'
                        >
                            @icon('clock', 'h-6 w-6 md:h-5 md:w-5 ' . ($time ? 'text-primary-500' : 'text-gray-400'))
                            <span class="font-medium">{{ $time ?? 'Add a time' }}</span>
                        </button>
                    @endif
                </div>
            @endif

            <livewire:nova:editor :content="old('editor-content', '')" />

            <div class="flex flex-col space-y-4 md:flex-row md:items-center md:space-x-4 md:space-y-0">
                @if ($allStories->count() > 1)
                    <button
                        type="button"
                        class="{{ $story ? 'border-primary-300 bg-primary-50 text-primary-600 hover:border-primary-400 hover:bg-primary-100' : 'border-gray-300 bg-white text-gray-500 hover:border-gray-500/30 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-900' }} flex items-center space-x-1.5 rounded-full border px-3 py-1.5 text-sm transition duration-200 md:px-2 md:py-0.5 md:text-xs"
                        wire:click='$emit("openModal", "posts:select-story-modal", {{ json_encode([$story->id]) }})'
                    >
                        @icon('book', 'h-6 w-6 md:h-5 md:w-5 shrink-0 ' . ($story ? 'text-primary-500' : 'text-gray-400'))
                        <span class="font-medium">{{ $story->title ?? 'Choose a story' }}</span>
                        <x-icon.chevron-down class="h-4 w-4 shrink-0 text-primary-500" />
                    </button>
                @else
                    <div
                        class="{{ $story ? 'border-primary-300 bg-primary-50 text-primary-600 dark:border-primary-600 dark:bg-primary-800 dark:text-primary-400' : 'border-gray-300 bg-white text-gray-500 hover:border-gray-500/30 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-900' }} flex items-center space-x-1.5 rounded-full border px-3 py-1.5 text-sm transition md:px-2 md:py-0.5 md:text-xs"
                    >
                        @icon('book', 'h-6 w-6 md:h-5 md:w-5 ' . ($story ? 'text-primary-500' : 'text-gray-400'))
                        <span class="font-medium">{{ $story->title ?? 'Choose a story' }}</span>
                    </div>
                @endif

                @if ($postType->fields->rating->enabled)
                    <div
                        class="flex cursor-pointer items-center space-x-1.5 rounded-full border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-500 transition hover:border-gray-500/30 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-900 md:px-2 md:py-0.5 md:text-xs"
                    >
                        @icon('mature', 'h-6 w-6 md:h-5 md:w-5 text-gray-400')
                        <span class="font-medium">Set content rating</span>
                    </div>
                @endif
            </div>

            @if ($this->showPostPositionControl)
                <x-input.group label="Post position">
                    <ul
                        class="w-full rounded-lg border border-gray-300 bg-gray-50 dark:border-none dark:bg-gray-700 dark:highlight-white/5 md:w-2/3"
                    >
                        @if ($previousPost)
                            <li>
                                <article>
                                    <a
                                        href="#"
                                        class="relative grid items-start overflow-hidden rounded-md p-3 transition duration-200 ease-in-out hover:bg-white dark:hover:bg-gray-900 sm:p-5"
                                        wire:click.prevent='$emit("openModal", "posts:read-post-modal", {{ json_encode([$previousPost->id]) }})'
                                    >
                                        <div
                                            class="row-start-1 mb-1 flex items-baseline font-medium md:col-start-1 md:row-end-3 md:mb-0"
                                        >
                                            <svg
                                                viewBox="0 0 12 12"
                                                class="mr-6 h-3 w-3 overflow-visible text-gray-400 dark:text-gray-500"
                                            >
                                                <circle cx="6" cy="6" r="6" fill="currentColor"></circle>
                                                <path
                                                    d="M 6 18 V 500"
                                                    fill="none"
                                                    stroke-width="2"
                                                    stroke="currentColor"
                                                    class="text-gray-400 dark:text-gray-500"
                                                ></path>
                                            </svg>
                                            <div class="flex flex-col items-start space-y-1">
                                                <div class="text-gray-900 dark:text-white">
                                                    {{ $previousPost->title }}
                                                </div>

                                                @if ($previousPost->location || $previousPost->day || $previousPost->time)
                                                    <div class="flex items-center space-x-6">
                                                        @if ($previousPost->location)
                                                            <div
                                                                class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400"
                                                            >
                                                                @icon('location', 'h-5 w-5 text-gray-400 dark:text-gray-500 shrink-0')
                                                                <span>{{ $previousPost->location }}</span>
                                                            </div>
                                                        @endif

                                                        @if ($previousPost->day)
                                                            <div
                                                                class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400"
                                                            >
                                                                @icon('calendar', 'h-5 w-5 text-gray-400 dark:text-gray-500 shrink-0')
                                                                <span>{{ $previousPost->day }}</span>
                                                            </div>
                                                        @endif

                                                        @if ($previousPost->time)
                                                            <div
                                                                class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400"
                                                            >
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
                                <button
                                    type="button"
                                    class="group relative grid w-full items-start overflow-hidden rounded-md p-3 transition hover:bg-white dark:hover:bg-gray-900 sm:p-5"
                                >
                                    <div
                                        class="row-start-1 mb-1 flex items-center font-medium md:col-start-1 md:row-end-3 md:mb-0"
                                    >
                                        <svg viewBox="0 0 12 12" class="mr-6 h-3 w-3 overflow-visible text-primary-500">
                                            <circle cx="6" cy="6" r="6" fill="currentColor"></circle>
                                            <circle
                                                cx="6"
                                                cy="6"
                                                r="11"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                class="text-primary-500"
                                            ></circle>

                                            @if ($previousPost)
                                                <path
                                                    d="M 6 -6 V -30"
                                                    fill="none"
                                                    stroke-width="2"
                                                    stroke="currentColor"
                                                    class="text-gray-400 dark:text-gray-500"
                                                ></path>
                                            @endif

                                            @if ($nextPost)
                                                <path
                                                    d="M 6 18 V 500"
                                                    fill="none"
                                                    stroke-width="2"
                                                    stroke="currentColor"
                                                    class="text-gray-400 dark:text-gray-500"
                                                ></path>
                                            @endif
                                        </svg>
                                        <span class="font-bold text-gray-900 dark:text-white">
                                            {{ $title ?? 'This '.strtolower($postType->name) }}
                                        </span>
                                        <div
                                            class="invisible ml-12 inline-flex items-center space-x-1 text-sm text-gray-400 group-hover:visible"
                                        >
                                            @icon('arrows-sort', 'h-5 w-5 text-gray-400 shrink-0')
                                            <span>Change post position</span>
                                        </div>
                                    </div>
                                </button>
                            </article>
                        </li>

                        @if ($nextPost)
                            <li>
                                <article>
                                    <a
                                        href="#"
                                        class="relative grid items-start overflow-hidden rounded-md p-3 transition hover:bg-white sm:p-5"
                                        wire:click.prevent='$emit("openModal", "posts:read-post-modal", {{ json_encode([$nextPost->id]) }})'
                                    >
                                        <div
                                            class="row-start-1 mb-1 flex items-baseline font-medium md:col-start-1 md:row-end-3 md:mb-0"
                                        >
                                            <svg
                                                viewBox="0 0 12 12"
                                                class="mr-6 h-3 w-3 overflow-visible text-gray-400"
                                            >
                                                <circle cx="6" cy="6" r="6" fill="currentColor"></circle>
                                                <path
                                                    d="M 6 -6 V -30"
                                                    fill="none"
                                                    stroke-width="2"
                                                    stroke="currentColor"
                                                    class="text-gray-400"
                                                ></path>
                                            </svg>
                                            <div class="flex flex-col items-start space-y-1">
                                                <div class="text-gray-900">{{ $nextPost->title }}</div>

                                                @if ($nextPost->location || $nextPost->day || $nextPost->time)
                                                    <div class="flex items-center space-x-6">
                                                        @if ($nextPost->location)
                                                            <div
                                                                class="flex items-center space-x-1 text-sm text-gray-600"
                                                            >
                                                                @icon('location', 'h-5 w-5 text-gray-400 shrink-0')
                                                                <span>{{ $nextPost->location }}</span>
                                                            </div>
                                                        @endif

                                                        @if ($nextPost->day)
                                                            <div
                                                                class="flex items-center space-x-1 text-sm text-gray-600"
                                                            >
                                                                @icon('calendar', 'h-5 w-5 text-gray-400 shrink-0')
                                                                <span>{{ $nextPost->day }}</span>
                                                            </div>
                                                        @endif

                                                        @if ($nextPost->time)
                                                            <div
                                                                class="flex items-center space-x-1 text-sm text-gray-600"
                                                            >
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
            @endif

            @if ($postType->fields->summary->enabled)
                <x-input.group
                    label="Post Summary"
                    help="If your post contains content intended only for mature audiences or that could be difficult for some people to read, you can provide a summary of the post."
                    class="w-full md:w-2/3"
                >
                    <x-input.textarea rows="3">{{ old('summary', '') }}</x-input.textarea>
                </x-input.group>
            @endif
        </div>
    </x-content-box>

    <div
        class="flex flex-col justify-between space-y-4 rounded-b-lg border-t border-gray-200 px-4 py-4 dark:border-gray-700 md:flex-row-reverse md:items-center md:space-x-6 md:space-y-0 md:space-x-reverse md:px-6 md:py-6"
    >
        <div
            class="flex flex-col space-y-4 md:flex-row-reverse md:items-center md:space-x-6 md:space-y-0 md:space-x-reverse"
        >
            <x-button.filled wire:click="publish" color="primary">Publish</x-button.filled>

            <x-button.filled wire:click="save" color="gray">Save</x-button.filled>
        </div>

        {{-- @can('delete', $post) --}}
        <div>
            <x-button.text href="#" color="gray-danger" size="none">Discard draft</x-button.text>
        </div>
        {{-- @endcan --}}
    </div>
</x-panel>
