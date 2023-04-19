<x-write-post-wizard-layout :steps="$steps">
    @if ($this->shouldShowParticipantsPanel || $this->shouldShowPositionPanel)
        <x-form action="">
            @if ($this->shouldShowPositionPanel)
                <x-form.section title="Set post position" message="Posts live on a timeline which allows you to set exactly where this post should appear in the story's timeline.">
                    <ul class="bg-white dark:bg-gray-700 dark:border-none dark:highlight-white/5 rounded-lg w-full">
                        @if ($previousPost)
                            <li>
                                <article>
                                    <a href="#" class="grid items-start relative rounded-md p-3 sm:p-5 overflow-hidden hover:bg-gray-100 dark:hover:bg-gray-900 transition ease-in-out duration-200" wire:click.prevent='$emit("openModal", "posts:read-post-modal", {{ json_encode([$previousPost->id]) }})'>
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
                                    <div class="md:col-start-1 row-start-1 md:row-end-3 flex items-center font-medium mb-1 md:mb-0 text-left">
                                        <svg viewBox="0 0 12 12" class="w-3 h-3 mr-6 overflow-visible text-primary-500">
                                            <circle cx="6" cy="6" r="6" fill="currentColor"></circle>
                                            <circle cx="6" cy="6" r="11" fill="none" stroke="currentColor" stroke-width="2" class="text-primary-500"></circle>

                                            @if ($previousPost)
                                                <path d="M 6 -6 V -100000" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-400 dark:text-gray-500"></path>
                                            @endif

                                            @if ($nextPost)
                                                <path d="M 6 18 V 100000" fill="none" stroke-width="2" stroke="currentColor" class="text-gray-400 dark:text-gray-500"></path>
                                            @endif
                                        </svg>
                                        <span class="text-gray-900 dark:text-gray-100 font-bold">{{ $post->title ?? 'This ' . strtolower($postType->name) }}</span>
                                        <a
                                            role="button"
                                            class="shrink-0 inline-flex items-center space-x-1 invisible group-hover:visible text-sm text-gray-400 ml-12"
                                            wire:click='$emit("openModal", "posts:select-post-position-modal", {{ json_encode([$post->story_id]) }})'
                                        >
                                            @icon('arrow-sort', 'h-5 w-5 text-gray-400 shrink-0')
                                            <span>Change post position</span>
                                        </a>
                                    </div>
                                </button>
                            </article>
                        </li>

                        @if ($nextPost)
                            <li>
                                <article>
                                    <a href="#" class="grid items-start relative rounded-md p-3 sm:p-5 overflow-hidden hover:bg-gray-100 dark:hover:bg-gray-900 transition ease-in-out duration-200" wire:click.prevent='$emit("openModal", "posts:read-post-modal", {{ json_encode([$nextPost->id]) }})'>
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
                                                            <div class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                                                @icon('location', 'h-5 w-5 text-gray-400 dark:text-gray-500 shrink-0')
                                                                <span>{{ $nextPost->location }}</span>
                                                            </div>
                                                        @endif

                                                        @if ($nextPost->day)
                                                            <div class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                                                @icon('calendar', 'h-5 w-5 text-gray-400 dark:text-gray-500 shrink-0')
                                                                <span>{{ $nextPost->day }}</span>
                                                            </div>
                                                        @endif

                                                        @if ($nextPost->time)
                                                            <div class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                                                @icon('clock', 'h-5 w-5 text-gray-400 dark:text-gray-500 shrink-0')
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
                </x-form.section>
            @endif

            @if ($this->shouldShowParticipantsPanel)
                <x-form.section title="Review participants">
                    <x-slot:message>
                        You can review participants to ensure that everyone who should receive credit for authoring the post gets it. If there is someone here who did not participate, you can remove them. If there is someone who did participate and isn't listed here, you can add them from the <x-link href="#" wire:click.prevent="showStep('posts:step:select-authors')" color="primary-text" size="none-base">Select Authors</x-link> screen.
                    </x-slot:message>

                    <div class="flex flex-col w-full">
                        @foreach ($participatingUsers as $participatingUser)
                            <div class="group relative flex items-center justify-between py-2 px-4 rounded odd:bg-gray-100 dark:odd:bg-gray-700/50">
                                <div class="flex flex-col sm:flex-row sm:items-center space-x-3">
                                    <div class="flex flex-col space-y-2">
                                        <div class="flex items-center">
                                            <span @class([
                                                'shrink-0 inline-block h-2 w-2 rounded-full mr-3',
                                                'bg-success-500' => in_array($participatingUser->id, $post->participants),
                                                'bg-danger-500' => ! in_array($participatingUser->id, $post->participants),
                                            ])></span>
                                            <span class="font-medium">{{ $participatingUser->name }}</span>
                                        </div>
                                        <div class="ml-5 space-y-1">
                                            @foreach($post->characterAuthors()->wherePivot('user_id', $participatingUser->id)->get() as $character)
                                                <div class="text-sm">{{ $character->displayName }}</div>
                                            @endforeach

                                            @foreach($post->userAuthors()->wherePivot('user_id', $participatingUser->id)->get() as $user)
                                                <div class="text-sm italic">{{ $user->pivot->as }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <x-dropdown placement="bottom-end">
                                    <x-slot:trigger color="gray-danger-text">@icon('delete', 'h-7 w-7 md:h-6 md:w-6')</x-slot:trigger>

                                    <x-dropdown.group>
                                        <x-dropdown.text>Are you sure you want to remove <strong class="font-semibold text-gray-700 dark:text-gray-200">{{ $participatingUser->name }}</strong> and any characters they're marked as writing as authors of this post?</x-dropdown.text>
                                    </x-dropdown.group>
                                    <x-dropdown.group>
                                        <x-dropdown.item-danger type="button" icon="delete" wire:click="removeParticipant({{ $participatingUser }})">
                                            Remove
                                        </x-dropdown.item-danger>
                                        <x-dropdown.item type="button" icon="prohibited" @click.prevent="$dispatch('dropdown-close')">Cancel</x-dropdown.item>
                                    </x-dropdown.group>
                                </x-dropdown>
                            </div>
                        @endforeach
                    </div>
                </x-form.section>
            @endif
        </x-form>
    @else
        <x-empty-state.large
            icon="check"
            title="You're good to go!"
            message="This is the first post of the story and you're the only participant, so nothing to do here except push the button."
        ></x-empty-state.large>
    @endif

    <x-content-box height="sm" class="flex flex-col space-y-4 rounded-b-lg border-t border-gray-200 dark:border-gray-200/10 md:flex-row-reverse md:items-center md:space-y-0 md:space-x-6 md:space-x-reverse justify-between">
        <div class="flex flex-col md:flex-row-reverse md:items-center md:space-x-reverse space-y-4 md:space-y-0 md:space-x-6">
            <x-button wire:click="publish" color="primary">Publish</x-button>
        </div>

        {{-- @can('delete', $post) --}}
            <div>
                <x-link href="#" color="gray-danger-text" size="none">Discard draft</x-link>
            </div>
        {{-- @endcan --}}
    </x-content-box>
</x-write-post-wizard-layout>
