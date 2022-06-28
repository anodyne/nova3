<x-write-post-wizard-layout :steps="$steps">
    @if ($characters->count() === 0 && $users->count() === 0)
            <div class="max-w-lg mx-auto py-8">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Add authors to your post</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by selecting characters and/or users who are authors of your post.</p>
                <ul role="list" class="mt-6 border-t border-b border-gray-200 dark:border-gray-200/10 divide-y divide-gray-200 dark:divide-gray-200/10">
                    <li>
                        <div class="relative group py-4 flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <x-badge size="square" color="primary">
                                    @icon('emoji', 'h-7 w-7')
                                </x-badge>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                    <a role="button" wire:click="$emit('openModal', 'posts:select-character-authors-modal')">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        Characters
                                    </a>
                                </div>
                                <p class="text-sm text-gray-500">Add any characters that are involved in the post.</p>
                            </div>
                            <div class="flex-shrink-0 self-center">
                                <x-icon.chevron-right class="h-5 w-5 text-gray-400 dark:text-gray-600 group-hover:text-gray-500 transition"></x-icon.chevron-right>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="relative group py-4 flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <x-badge size="square" color="info">
                                    @icon('users', 'h-7 w-7')
                                </x-badge>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                    <a role="button" wire:click="$emit('openModal', 'posts:select-user-authors-modal')">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        Users
                                    </a>
                                </div>
                                <p class="text-sm text-gray-500">Add additional users who want to write with you on this post.</p>
                            </div>
                            <div class="flex-shrink-0 self-center">
                                <x-icon.chevron-right class="h-5 w-5 text-gray-400 dark:text-gray-600 group-hover:text-gray-500 transition"></x-icon.chevron-right>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="mt-6 flex">
                    <x-button color="primary-text" size="none" wire:click="nextStep">
                        Or start writing your post and add authors later<span aria-hidden="true"> &rarr;</span>
                    </x-button>
                </div>
            </div>
    @else
        @if (! $post->type->options->multipleAuthors && $users->count() === 0 || $post->type->options->multipleAuthors)
            <x-content-box height="none" class="mt-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-xl text-gray-900 dark:text-gray-100 tracking-tight">Characters</h3>

                    @if ($this->canAddAuthors)
                        <x-button color="primary-outline" size="xs" wire:click="$emit('openModal', 'posts:select-character-authors-modal')">Add characters</x-button>
                    @endif
                </div>
            </x-content-box>

            <x-content-box width="none" height="none">
                @if ($characters->count() === 0)
                    <x-panel as="light well" class="max-w-xl mx-auto">
                        <x-content-box class="text-center">
                            @icon('users', 'mx-auto h-12 w-12 text-gray-400 dark:text-gray-500')

                            <h3 class="mt-2 text-base font-medium text-gray-600 dark:text-gray-400">No character authors selected</h3>

                            <button class="space-x-3 mt-4">
                                <span>Add characters</span>
                            </button>
                        </x-content-box>
                    </x-panel>
                @else
                    <x-table-list columns="5">
                        <x-slot:header>
                            <div class="col-span-3">Name</div>
                            <div class="col-span-2">Played by</div>
                        </x-slot:header>

                        @foreach ($characters as $character)
                            <x-table-list.row>
                                <div class="flex items-center col-span-3">
                                    <x-avatar.character
                                        :character="$character"
                                        size="sm"
                                        :secondary-positions="false"
                                    ></x-avatar.character>
                                </div>

                                <div @class([
                                    'flex items-center col-span-2',
                                ])>
                                    @if ($character->type->name() === 'support')
                                        <x-input.select wire:model="selectedCharacters.{{ $character->id }}.user_id">
                                            <option value="">Select a user (optional)</option>
                                            @foreach ($this->allUsers as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </x-input.select>
                                    @else
                                        @if ($character->activeUsers()->count() === 1)
                                            {{ $character->activeUsers()->first()->name }}
                                        @else
                                            <x-input.select wire:model="selectedCharacters.{{ $character->id }}.user_id">
                                                <option value="">Select an assigned user</option>
                                                @foreach ($character->activeUsers as $user)
                                                    <option
                                                        value="{{ $user->id }}"
                                                        wire:key="c-{{ $character->id }}-u-{{ $user->id }}"
                                                    >{{ $user->name }}</option>
                                                @endforeach
                                            </x-input.select>
                                        @endif
                                    @endif
                                </div>

                                <x-slot:controls>
                                    <x-button type="button" color="gray-error-text" size="none" wire:click="removeCharacterAuthor({{ $character->id }})">
                                        @icon('delete', 'h-6 w-6')
                                    </x-button>
                                </x-slot:controls>
                            </x-table-list.row>
                        @endforeach
                    </x-table-list>
                @endif
            </x-content-box>
        @endif

        @if (! $post->type->options->multipleAuthors && $characters->count() === 0 || $post->type->options->multipleAuthors)
            <x-content-box height="none" class="mt-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-xl text-gray-900 dark:text-gray-100 tracking-tight">Users</h3>

                    @if ($this->canAddAuthors)
                        <x-button color="primary-outline" size="xs" wire:click="$emit('openModal', 'posts:select-user-authors-modal')">Add users</x-button>
                    @endif
                </div>
            </x-content-box>

            <x-content-box width="none" height="none">
                @if ($users->count() === 0)
                    <x-panel as="light well" class="max-w-xl mx-auto">
                        <x-content-box class="text-center">
                            @icon('users', 'mx-auto h-12 w-12 text-gray-400 dark:text-gray-500')

                            <h3 class="mt-2 text-base font-medium text-gray-600 dark:text-gray-400">No user authors selected</h3>

                            <button class="space-x-3 mt-4">
                                <span>Add users</span>
                            </button>
                        </x-content-box>
                    </x-panel>
                @else
                    <x-table-list columns="5">
                        <x-slot:header>
                            <div class="col-span-3">Name</div>
                            <div class="col-span-2">Playing as</div>
                        </x-slot:header>

                        @foreach ($users as $user)
                            <x-table-list.row>
                                <div class="flex items-center col-span-3">
                                    <x-avatar.user
                                        :user="$user"
                                        size="sm"
                                    ></x-avatar.user>
                                </div>

                                <div @class([
                                    'flex items-center col-span-2',
                                ])>
                                    <x-input.text
                                        placeholder="Who is this user playing? (optional)"
                                        wire:model.debounce.1s="selectedUsers.{{ $user->id }}.as"
                                        wire:key="u-{{ $user->id }}-as"
                                    ></x-input.text>
                                </div>

                                <x-slot:controls>
                                    <x-button type="button" color="gray-error-text" size="none" wire:click="removeUserAuthor({{ $user->id }})">
                                        @icon('delete', 'h-6 w-6')
                                    </x-button>
                                </x-slot:controls>
                            </x-table-list.row>
                        @endforeach
                    </x-table-list>
                @endif
            </x-content-box>
        @endif
    @endif

    <x-content-box height="sm" class="flex flex-col space-y-4 rounded-b-lg border-t border-gray-200 dark:border-gray-200/10 md:flex-row-reverse md:items-center md:space-y-0 md:space-x-6 md:space-x-reverse justify-between">
        <div class="flex flex-col md:flex-row-reverse md:items-center md:space-x-reverse space-y-4 md:space-y-0 md:space-x-6">
            <x-button wire:click="nextStep" color="primary">Next: Write Post</x-button>
        </div>
    </x-content-box>
</x-write-post-wizard-layout>
