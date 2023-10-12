<x-write-post-wizard-layout :steps="$steps">
    @if ($characters->count() === 0 && $users->count() === 0)
        <div class="mx-auto max-w-lg py-8">
            <x-h2>Add authors to your post</x-h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Get started by selecting the characters and/or users who will be authors of your post.
            </p>
            <ul
                role="list"
                class="mt-6 divide-y divide-gray-200 border-b border-t border-gray-200 dark:divide-gray-700 dark:border-gray-700"
            >
                <li>
                    <div class="group relative flex items-start space-x-3 py-4">
                        <div class="flex-shrink-0">
                            <x-badge size="square" color="primary">
                                <x-icon name="characters" size="lg"></x-icon>
                            </x-badge>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-medium text-gray-900 dark:text-gray-100">
                                <a
                                    role="button"
                                    wire:click="$dispatch('openModal', 'posts:select-character-authors-modal')"
                                >
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    Characters
                                </a>
                            </div>
                            <p class="text-sm text-gray-500">Add any characters that are involved in the post.</p>
                        </div>
                        <div class="flex-shrink-0 self-center">
                            <x-icon.chevron-right
                                class="h-5 w-5 text-gray-400 transition group-hover:text-gray-500 dark:text-gray-600"
                            ></x-icon.chevron-right>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="group relative flex items-start space-x-3 py-4">
                        <div class="flex-shrink-0">
                            <x-badge size="square" color="info">
                                <x-icon name="users" size="lg"></x-icon>
                            </x-badge>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-medium text-gray-900 dark:text-gray-100">
                                <a role="button" wire:click="$dispatch('openModal', 'posts:select-user-authors-modal')">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    Users
                                </a>
                            </div>
                            <p class="text-sm text-gray-500">
                                Add additional users who want to write with you on this post.
                            </p>
                        </div>
                        <div class="flex-shrink-0 self-center">
                            <x-icon.chevron-right
                                class="h-5 w-5 text-gray-400 transition group-hover:text-gray-500 dark:text-gray-600"
                            ></x-icon.chevron-right>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    @else
        @if (! $post->postType->options->allowsMultipleAuthors && $users->count() === 0 || $post->postType->options->allowsMultipleAuthors)
            <x-content-box height="none" class="mt-6">
                <div class="flex justify-between">
                    <div class="max-w-2xl">
                        <x-h2>Characters</x-h2>
                        <p class="mt-0.5 text-sm text-gray-500">
                            Any character on the manifest can be added as an author. If the character is assigned to
                            multiple users, you can select which user will be playing the character. If the character is
                            a support character, you can assign any users to play that character.
                        </p>
                    </div>

                    @if ($this->canAddAuthors)
                        <div class="ml-6 shrink-0">
                            <x-button.filled
                                color="neutral"
                                wire:click="$dispatch('openModal', 'posts:select-character-authors-modal')"
                            >
                                Add characters
                            </x-button.filled>
                        </div>
                    @endif
                </div>
            </x-content-box>

            <x-content-box width="none" height="none">
                @if ($characters->count() === 0)
                    <x-panel as="light-well" class="mx-auto max-w-xl">
                        <x-content-box class="text-center">
                            <x-icon
                                name="characters"
                                size="h-12 w-12"
                                class="mx-auto text-gray-400 dark:text-gray-500"
                            ></x-icon>
                            <x-h3 class="mt-2">No character authors</x-h3>
                        </x-content-box>
                    </x-panel>
                @else
                    <x-table-list columns="5">
                        <x-slot name="header">
                            <div class="col-span-3">Name</div>
                            <div class="col-span-2">Played by</div>
                        </x-slot>

                        @foreach ($characters as $character)
                            <x-table-list.row>
                                <div class="col-span-3 flex items-center">
                                    <x-avatar.character
                                        :character="$character"
                                        size="sm"
                                        :secondary-positions="false"
                                    ></x-avatar.character>
                                </div>

                                <div
                                    @class([
                                        'col-span-2 flex items-center',
                                    ])
                                >
                                    @if ($character->type->value === 'support')
                                        <x-input.select wire:model="selectedCharacters.{{ $character->id }}.user_id">
                                            <option value="">Select a user (optional)</option>
                                            @foreach ($this->allUsers as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </x-input.select>
                                    @else
                                        @if ($character->activeUsers()->count() === 1)
                                            {{ $character->activeUsers()->first()->name }}
                                        @else
                                            <x-input.select
                                                wire:model="selectedCharacters.{{ $character->id }}.user_id"
                                            >
                                                <option value="">Select an assigned user</option>
                                                @foreach ($character->activeUsers as $user)
                                                    <option
                                                        value="{{ $user->id }}"
                                                        wire:key="c-{{ $character->id }}-u-{{ $user->id }}"
                                                    >
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </x-input.select>
                                        @endif
                                    @endif
                                </div>

                                <x-slot name="actions">
                                    <x-dropdown placement="bottom-end">
                                        <x-slot name="trigger" color="neutral-danger">
                                            <x-icon name="trash" size="md"></x-icon>
                                        </x-slot>

                                        <x-dropdown.group>
                                            <x-dropdown.text>
                                                Are you sure you want to remove
                                                <strong class="font-semibold text-gray-700 dark:text-gray-200">
                                                    {{ $character->name }}
                                                </strong>
                                                as an author of this post?
                                            </x-dropdown.text>
                                        </x-dropdown.group>
                                        <x-dropdown.group>
                                            <x-dropdown.item-danger
                                                type="button"
                                                icon="trash"
                                                wire:click="removeCharacterAuthor({{ $character->id }})"
                                            >
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
                                </x-slot>
                            </x-table-list.row>
                        @endforeach
                    </x-table-list>
                @endif
            </x-content-box>
        @endif

        @if (! $post->postType->options->allowsMultipleAuthors && $characters->count() === 0 || $post->postType->options->allowsMultipleAuthors)
            <x-content-box height="none" class="mt-6">
                <div class="flex justify-between">
                    <div class="max-w-2xl">
                        <x-h2>Users</x-h2>
                        <p class="mt-0.5 text-sm text-gray-500">
                            Users can be added as authors to allow collaborative writing with characters that may not be
                            on the manifest or may be story specific.
                        </p>
                    </div>

                    @if ($this->canAddAuthors)
                        <div class="ml-6 shrink-0">
                            <x-button.filled
                                color="neutral"
                                wire:click="$dispatch('openModal', 'posts:select-user-authors-modal')"
                            >
                                Add users
                            </x-button.filled>
                        </div>
                    @endif
                </div>
            </x-content-box>

            <x-content-box width="none" height="none">
                @if ($users->count() === 0)
                    <x-panel as="light-well" class="mx-auto max-w-xl">
                        <x-content-box class="text-center">
                            <x-icon
                                name="users"
                                size="h-12 w-12"
                                class="mx-auto text-gray-400 dark:text-gray-500"
                            ></x-icon>
                            <x-h3 class="mt-2">No user authors</x-h3>
                        </x-content-box>
                    </x-panel>
                @else
                    <x-table-list columns="5">
                        <x-slot name="header">
                            <div class="col-span-3">Name</div>
                            <div class="col-span-2">Playing as</div>
                        </x-slot>

                        @foreach ($users as $user)
                            <x-table-list.row>
                                <div class="col-span-3 flex items-center">
                                    <x-avatar.user :user="$user" size="sm"></x-avatar.user>
                                </div>

                                <div
                                    @class([
                                        'col-span-2 flex items-center',
                                    ])
                                >
                                    <x-input.text
                                        placeholder="Who is this user playing? (optional)"
                                        wire:model.live.debounce.500ms="selectedUsers.{{ $user->id }}.as"
                                        wire:key="u-{{ $user->id }}-as"
                                    ></x-input.text>
                                </div>

                                <x-slot name="actions">
                                    <x-dropdown placement="bottom-end">
                                        <x-slot name="trigger" color="neutral-danger">
                                            <x-icon name="trash" size="md"></x-icon>
                                        </x-slot>

                                        <x-dropdown.group>
                                            <x-dropdown.text>
                                                Are you sure you want to remove
                                                <strong class="font-semibold text-gray-700 dark:text-gray-200">
                                                    {{ $user->name }}
                                                </strong>
                                                as an author of this post?
                                            </x-dropdown.text>
                                        </x-dropdown.group>
                                        <x-dropdown.group>
                                            <x-dropdown.item-danger
                                                type="button"
                                                icon="trash"
                                                wire:click="removeUserAuthor({{ $user->id }})"
                                            >
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
                                </x-slot>
                            </x-table-list.row>
                        @endforeach
                    </x-table-list>
                @endif
            </x-content-box>
        @endif
    @endif

    @if ($this->canGoToNextStep)
        <x-content-box
            height="sm"
            class="flex flex-col justify-between space-y-4 rounded-b-lg border-t border-gray-200 dark:border-gray-700 md:flex-row-reverse md:items-center md:space-x-6 md:space-y-0 md:space-x-reverse"
        >
            <div
                class="flex flex-col space-y-4 md:flex-row-reverse md:items-center md:space-x-6 md:space-y-0 md:space-x-reverse"
            >
                <x-button.filled wire:click="nextStep" color="primary">Next: Write post</x-button.filled>
            </div>
        </x-content-box>
    @else
        <x-content-box
            class="flex justify-end rounded-b-lg border-t border-gray-200 bg-gray-50 font-medium text-gray-400 dark:border-gray-700 dark:bg-gray-700/50 dark:text-gray-500"
        >
            {{ $this->canGoToNextStepMessage }}
        </x-content-box>
    @endif
</x-write-post-wizard-layout>
