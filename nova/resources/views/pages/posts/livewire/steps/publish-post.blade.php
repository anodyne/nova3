<x-write-post-wizard-layout
    :steps="$steps"
    message="Set your post’s content rating, summary, and position within the story before publishing"
>
    <div class="divide-y divide-gray-200 dark:divide-gray-800">
        @if ($postType->fields->rating->enabled)
            <div class="grid grid-cols-3 gap-8">
                <x-content-box class="space-y-2">
                    <x-h2>Content rating</x-h2>
                    <p class="text-sm/6 text-gray-600 dark:text-gray-400">
                        Let players and readers know what to expect from your post by setting the content ratings. These
                        content ratings follow the game’s default ratings unless you specify otherwise.
                    </p>
                </x-content-box>
                <x-content-box class="col-span-2">
                    <div class="w-full space-y-6 lg:w-3/4">
                        <x-input.group label="Language" class="w-full">
                            <livewire:rating area="language" wire:model.live.number="form.rating_language" />
                        </x-input.group>

                        <x-input.group label="Sex" class="w-full">
                            <livewire:rating area="sex" wire:model.live.number="form.rating_sex" />
                        </x-input.group>

                        <x-input.group label="Violence" class="w-full">
                            <livewire:rating area="violence" wire:model.live.number="form.rating_violence" />
                        </x-input.group>
                    </div>
                </x-content-box>
            </div>
        @endif

        @if ($postType->fields->summary->enabled)
            <div class="grid grid-cols-3 gap-8">
                <x-content-box class="space-y-2">
                    <x-h2>Post summary</x-h2>
                    <p class="text-sm/6 text-gray-600 dark:text-gray-400">
                        If your post contains content intended only for mature audiences or that could be difficult for
                        some people to read, you can provide a summary of the post.
                    </p>
                </x-content-box>
                <x-content-box class="col-span-2">
                    <div class="w-full lg:w-3/4">
                        <x-input.textarea wire:model.blur="form.summary" rows="5"></x-input.textarea>
                    </div>
                </x-content-box>
            </div>
        @endif

        @if ($shouldShowParticipantsPanel)
            <div class="grid grid-cols-3 gap-8">
                <x-content-box class="space-y-2">
                    <x-h2>Review participants</x-h2>
                    <p class="text-sm/6 text-gray-600 dark:text-gray-400">
                        You can review players who participated in writing this post to ensure that the proper authors
                        are credited.
                    </p>
                    <p class="text-sm/6 text-gray-600 dark:text-gray-400">
                        If there is someone here who did not participate (indicated by a red status badge), you can
                        remove them. If there is someone who did participate and isn’t listed here, you can add them
                        from the
                        <x-button.text
                            type="button"
                            wire:click="$dispatch('showStep', { toStepName: 'posts-wizard-step-setup' })"
                        >
                            Setup Post
                        </x-button.text>
                        screen.
                    </p>
                </x-content-box>
                <x-content-box class="col-span-2">
                    <x-panel class="w-full lg:w-3/4">
                        <div class="divide-y divide-gray-200 rounded-b-lg dark:divide-gray-800">
                            @foreach ($participatingUsers as $participatingUser)
                                <x-content-box height="xs" width="sm" class="flex items-center justify-between gap-6">
                                    <div class="flex flex-col space-x-3 sm:flex-row sm:items-center">
                                        <div class="flex flex-col gap-0.5">
                                            <div class="flex items-center">
                                                <span
                                                    @class([
                                                        'mr-3 inline-block h-2 w-2 shrink-0 rounded-full',
                                                        'bg-success-500' => in_array($participatingUser->id, $post->participants ?? []),
                                                        'bg-danger-500' => ! in_array($participatingUser->id, $post->participants ?? []),
                                                    ])
                                                ></span>
                                                <span class="font-medium">{{ $participatingUser->name }}</span>
                                            </div>
                                            <div class="ml-5">
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
                                            <x-icon name="remove" size="md"></x-icon>
                                        </x-slot>

                                        <x-dropdown.group>
                                            <x-dropdown.text>
                                                Are you sure you want to remove
                                                <strong class="font-semibold text-gray-700 dark:text-gray-200">
                                                    {{ $participatingUser->name }}
                                                </strong>
                                                and any characters they’re marked as writing as authors of this post?
                                            </x-dropdown.text>
                                        </x-dropdown.group>
                                        <x-dropdown.group>
                                            <x-dropdown.item-danger
                                                type="button"
                                                icon="remove"
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
                                </x-content-box>
                            @endforeach

                            @if ($hasNonParticipants)
                                <x-content-box
                                    height="xs"
                                    width="sm"
                                    class="flex items-center rounded-b-lg bg-gray-50 dark:bg-gray-900/50"
                                >
                                    <x-dropdown placement="bottom-start">
                                        <x-slot name="trigger" color="neutral-danger">
                                            <div class="flex items-center gap-2">
                                                <x-icon name="remove" size="md"></x-icon>
                                                <span>Remove all non-participating users</span>
                                            </div>
                                        </x-slot>

                                        <x-dropdown.group>
                                            <x-dropdown.text>
                                                Are you sure you want to remove all users who did not participate in
                                                writing this post and their characters?
                                            </x-dropdown.text>
                                        </x-dropdown.group>
                                        <x-dropdown.group>
                                            <x-dropdown.item-danger
                                                type="button"
                                                icon="remove"
                                                wire:click="removeAllNonParticipants"
                                            >
                                                Remove all
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
                                </x-content-box>
                            @endif
                        </div>
                    </x-panel>
                </x-content-box>
            </div>
        @endif

        @if ($shouldShowPositionPanel)
            <div class="grid grid-cols-3 gap-8">
                <x-content-box class="space-y-2">
                    <x-h2>Post position</x-h2>
                    <p class="text-sm/6 text-gray-600 dark:text-gray-400">
                        Posts live on a timeline which allows you to set exactly where this post should appear in the
                        story’s timeline.
                    </p>
                </x-content-box>
                <x-content-box class="col-span-2">
                    <ul
                        class="w-full rounded-lg bg-white dark:border-none dark:bg-gray-700 dark:highlight-white/5 lg:w-3/4"
                    >
                        @if ($previousPost)
                            <li>
                                <article>
                                    <button
                                        type="button"
                                        class="relative grid items-start overflow-hidden rounded-md p-3 transition duration-200 ease-in-out hover:bg-gray-100 dark:hover:bg-gray-900 sm:p-5"
                                        wire:click="$dispatch('openModal', { component: 'posts-read-post-modal', arguments: { post: {{ $previousPost->id }}}})"
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
                                    </button>
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
                                            wire:click="$dispatch('openModal', { component: 'posts-select-post-position-modal', arguments: { story: {{ $post->story_id }}}})"
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
                                    <button
                                        type="button"
                                        class="relative grid items-start overflow-hidden rounded-md p-3 transition duration-200 ease-in-out hover:bg-gray-100 dark:hover:bg-gray-900 sm:p-5"
                                        wire:click="$dispatch('openModal', { component: 'posts-read-post-modal', arguments: { post: {{ $nextPost->id }}}})"
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
                                    </button>
                                </article>
                            </li>
                        @endif
                    </ul>
                </x-content-box>
            </div>
        @endif
    </div>

    <div
        class="flex flex-col rounded-b-lg border-t border-gray-200 px-4 py-4 dark:border-gray-800 md:flex-row md:items-center md:justify-between md:px-6 md:py-6"
    >
        <div class="flex items-center">
            @can('discardDraft', $post)
                <x-dropdown placement="bottom-start">
                    <x-slot name="trigger" color="neutral-danger" leading="trash" size="none">Discard draft</x-slot>

                    <x-dropdown.group>
                        <x-dropdown.text>
                            Are you sure you want to discard this {{ str($postType->name)->lower() }} draft?
                        </x-dropdown.text>
                    </x-dropdown.group>
                    <x-dropdown.group>
                        <x-dropdown.item-danger type="button" icon="trash" wire:click="discardDraft({{ $post->id }})">
                            Discard
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
            @endcan

            @can('delete', $post)
                <x-dropdown placement="bottom-start">
                    <x-slot name="trigger" color="neutral-danger" leading="trash" size="none">Delete draft</x-slot>

                    <x-dropdown.group>
                        <x-dropdown.text>
                            Are you sure you want to delete this {{ str($postType->name)->lower() }}?
                        </x-dropdown.text>
                    </x-dropdown.group>
                    <x-dropdown.group>
                        <x-dropdown.item-danger type="button" icon="trash" wire:click="deletePost({{ $post->id }})">
                            Delete
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
            @endcan
        </div>

        <div class="flex items-center gap-4">
            <x-button.filled wire:click="save" color="neutral">Save</x-button.filled>
            <x-button.filled wire:click="publish" color="primary">Publish post</x-button.filled>
        </div>
    </div>
</x-write-post-wizard-layout>
