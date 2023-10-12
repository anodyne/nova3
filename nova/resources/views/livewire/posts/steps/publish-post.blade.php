<x-write-post-wizard-layout :steps="$steps">
    @if ($this->shouldShowParticipantsPanel || $this->shouldShowPositionPanel)
        <x-form action="">
            @if ($this->shouldShowPositionPanel)
                <x-form.section
                    title="Set post position"
                    message="Posts live on a timeline which allows you to set exactly where this post should appear in the story's timeline."
                >
                    <ul class="w-full rounded-lg bg-white dark:border-none dark:bg-gray-700 dark:highlight-white/5">
                        @if ($previousPost)
                            <li>
                                <article>
                                    <a
                                        href="#"
                                        class="relative grid items-start overflow-hidden rounded-md p-3 transition duration-200 ease-in-out hover:bg-gray-100 dark:hover:bg-gray-900 sm:p-5"
                                        wire:click.prevent='$dispatch("openModal", "posts:read-post-modal", {{ json_encode([$previousPost->id]) }})'
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
                                                <div class="text-gray-900 dark:text-gray-100">
                                                    {{ $previousPost->title }}
                                                </div>

                                                @if ($previousPost->location || $previousPost->day || $previousPost->time)
                                                    <div class="flex items-center space-x-6">
                                                        @if ($previousPost->location)
                                                            <div
                                                                class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400"
                                                            >
                                                                <x-icon
                                                                    name="location"
                                                                    size="sm"
                                                                    class="shrink-0 text-gray-400 dark:text-gray-500"
                                                                ></x-icon>
                                                                <span>{{ $previousPost->location }}</span>
                                                            </div>
                                                        @endif

                                                        @if ($previousPost->day)
                                                            <div
                                                                class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400"
                                                            >
                                                                <x-icon
                                                                    name="calendar"
                                                                    size="sm"
                                                                    class="shrink-0 text-gray-400 dark:text-gray-500"
                                                                ></x-icon>
                                                                <span>{{ $previousPost->day }}</span>
                                                            </div>
                                                        @endif

                                                        @if ($previousPost->time)
                                                            <div
                                                                class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400"
                                                            >
                                                                <x-icon
                                                                    name="clock"
                                                                    size="sm"
                                                                    class="shrink-0 text-gray-400 dark:text-gray-500"
                                                                ></x-icon>
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
                                        class="row-start-1 mb-1 flex items-center text-left font-medium md:col-start-1 md:row-end-3 md:mb-0"
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
                                                    d="M 6 -6 V -100000"
                                                    fill="none"
                                                    stroke-width="2"
                                                    stroke="currentColor"
                                                    class="text-gray-400 dark:text-gray-500"
                                                ></path>
                                            @endif

                                            @if ($nextPost)
                                                <path
                                                    d="M 6 18 V 100000"
                                                    fill="none"
                                                    stroke-width="2"
                                                    stroke="currentColor"
                                                    class="text-gray-400 dark:text-gray-500"
                                                ></path>
                                            @endif
                                        </svg>
                                        <span class="font-bold text-gray-900 dark:text-gray-100">
                                            {{ $post->title ?? 'This '.strtolower($postType->name) }}
                                        </span>
                                        <a
                                            role="button"
                                            class="invisible ml-12 inline-flex shrink-0 items-center space-x-1 text-sm text-gray-400 group-hover:visible"
                                            wire:click='$dispatch("openModal", "posts:select-post-position-modal", {{ json_encode([$post->story_id]) }})'
                                        >
                                            <x-icon
                                                name="arrows-sort"
                                                size="sm"
                                                class="shrink-0 text-gray-400"
                                            ></x-icon>
                                            <span>Change post position</span>
                                        </a>
                                    </div>
                                </button>
                            </article>
                        </li>

                        @if ($nextPost)
                            <li>
                                <article>
                                    <a
                                        href="#"
                                        class="relative grid items-start overflow-hidden rounded-md p-3 transition duration-200 ease-in-out hover:bg-gray-100 dark:hover:bg-gray-900 sm:p-5"
                                        wire:click.prevent='$dispatch("openModal", "posts:read-post-modal", {{ json_encode([$nextPost->id]) }})'
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
                                                                class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400"
                                                            >
                                                                <x-icon
                                                                    name="location"
                                                                    size="sm"
                                                                    class="shrink-0 text-gray-400 dark:text-gray-500"
                                                                ></x-icon>
                                                                <span>{{ $nextPost->location }}</span>
                                                            </div>
                                                        @endif

                                                        @if ($nextPost->day)
                                                            <div
                                                                class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400"
                                                            >
                                                                <x-icon
                                                                    name="calendar"
                                                                    size="sm"
                                                                    class="shrink-0 text-gray-400 dark:text-gray-500"
                                                                ></x-icon>
                                                                <span>{{ $nextPost->day }}</span>
                                                            </div>
                                                        @endif

                                                        @if ($nextPost->time)
                                                            <div
                                                                class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400"
                                                            >
                                                                <x-icon
                                                                    name="clock"
                                                                    size="sm"
                                                                    class="shrink-0 text-gray-400 dark:text-gray-500"
                                                                ></x-icon>
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
                        You can review participants to ensure that everyone who should receive credit for authoring the
                        post gets it. If there is someone here who did not participate, you can remove them. If there is
                        someone who did participate and isn't listed here, you can add them from the
                        <x-button.text
                            href="#"
                            wire:click.prevent="showStep('posts:step:select-authors')"
                            color="primary"
                        >
                            Select Authors
                        </x-button.text>
                        screen.
                    </x-slot>

                    <div class="flex w-full flex-col">
                        @foreach ($participatingUsers as $participatingUser)
                            <div
                                class="group relative flex items-center justify-between rounded px-4 py-2 odd:bg-gray-100 dark:odd:bg-gray-700/50"
                            >
                                <div class="flex flex-col space-x-3 sm:flex-row sm:items-center">
                                    <div class="flex flex-col space-y-2">
                                        <div class="flex items-center">
                                            <span
                                                @class([
                                                    'mr-3 inline-block h-2 w-2 shrink-0 rounded-full',
                                                    'bg-success-500' => in_array($participatingUser->id, $post->participants),
                                                    'bg-danger-500' => ! in_array($participatingUser->id, $post->participants),
                                                ])
                                            ></span>
                                            <span class="font-medium">{{ $participatingUser->name }}</span>
                                        </div>
                                        <div class="ml-5 space-y-1">
                                            @foreach ($post->characterAuthors()->wherePivot('user_id', $participatingUser->id)->get() as $character)
                                                <div class="text-sm">{{ $character->displayName }}</div>
                                            @endforeach

                                            @foreach ($post->userAuthors()->wherePivot('user_id', $participatingUser->id)->get() as $user)
                                                <div class="text-sm italic">{{ $user->pivot->as }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <x-dropdown placement="bottom-end">
                                    <x-slot name="trigger" color="neutral-danger">
                                        <x-icon name="trash" size="md"></x-icon>
                                    </x-slot>

                                    <x-dropdown.group>
                                        <x-dropdown.text>
                                            Are you sure you want to remove
                                            <strong class="font-semibold text-gray-700 dark:text-gray-200">
                                                {{ $participatingUser->name }}
                                            </strong>
                                            and any characters they're marked as writing as authors of this post?
                                        </x-dropdown.text>
                                    </x-dropdown.group>
                                    <x-dropdown.group>
                                        <x-dropdown.item-danger
                                            type="button"
                                            icon="trash"
                                            wire:click="removeParticipant({{ $participatingUser }})"
                                        >
                                            Remove
                                        </x-dropdown.item-danger>
                                        <x-dropdown.item
                                            type="button"
                                            icon="prohibited"
                                            x-on:click.prevent="$dispatch('dropdown-close')"
                                        >
                                            Cancel
                                        </x-dropdown.item>
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

    <x-content-box
        height="sm"
        class="flex flex-col justify-between space-y-4 rounded-b-lg border-t border-gray-200 dark:border-gray-700 md:flex-row-reverse md:items-center md:space-x-6 md:space-y-0 md:space-x-reverse"
    >
        <div
            class="flex flex-col space-y-4 md:flex-row-reverse md:items-center md:space-x-6 md:space-y-0 md:space-x-reverse"
        >
            <x-button.filled wire:click="publish" color="primary">Publish</x-button.filled>
        </div>

        {{-- @can('delete', $post) --}}
        <div>
            <x-button.text href="#" color="neutral-danger">Discard draft</x-button.text>
        </div>
        {{-- @endcan --}}
    </x-content-box>
</x-write-post-wizard-layout>
