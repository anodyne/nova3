<x-modal.slide-over title="Manage authors" icon="characters">
    <div class="space-y-6">
        <div class="space-y-3">
            <x-text size="lg">
                Any character on the manifest can be added as an author. If the character is assigned to multiple users,
                you can select which user will be playing the character. If the character is a support character, you
                can assign any user to play that character.
            </x-text>

            <x-text size="lg">
                Users can also be added as authors to allow collaborative writing with characters that may not be on the
                manifest or may be story specific.
            </x-text>
        </div>

        <x-form action="">
            <x-fieldset>
                <x-panel variant="well">
                    <x-panel variant="inset">
                        @if ($canAddAuthors)
                            <x-panel.manage.search :search="$search" :placeholder="$authorSearchPlaceholder">
                                @if ($filteredCharacters->count() > 0)
                                    <x-dropdown.group>
                                        <x-dropdown.header>Characters</x-dropdown.header>

                                        @foreach ($filteredCharacters as $character)
                                            <x-dropdown.item
                                                type="button"
                                                wire:click="addCharacterAuthor({{ $character->id }})"
                                            >
                                                {{ $character->display_name }}
                                            </x-dropdown.item>
                                        @endforeach
                                    </x-dropdown.group>
                                @endif

                                @if ($filteredUsers->count() > 0)
                                    <x-dropdown.group>
                                        <x-dropdown.header>Users</x-dropdown.header>

                                        @foreach ($filteredUsers as $user)
                                            <x-dropdown.item type="button" wire:click="addUserAuthor({{ $user->id }})">
                                                {{ $user->name }}
                                            </x-dropdown.item>
                                        @endforeach
                                    </x-dropdown.group>
                                @endif

                                @if ($filteredCharacters->isEmpty() && $filteredUsers->isEmpty())
                                    <x-empty-state.small icon="alert" title="No author(s) found"></x-empty-state.small>
                                @endif
                            </x-panel.manage.search>
                        @endif

                        @if ($characters->count() > 0 || $users->count() > 0)
                            <div class="divide-y divide-gray-950/5 dark:divide-white/5">
                                @foreach ($characters as $character)
                                    <x-spacing size="row" class="flex items-center justify-between gap-6">
                                        <x-avatar.character
                                            :character="$character"
                                            size="xs"
                                            :primary-rank="false"
                                            :secondary-positions="false"
                                        ></x-avatar.character>

                                        <div class="flex items-center gap-4">
                                            @if ($character->type->value === 'support')
                                                <x-select
                                                    wire:model.live="selectedCharacters.{{ $character->id }}.user_id"
                                                >
                                                    <option value="">Select a user (optional)</option>
                                                    @foreach ($allUsers as $user)
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </x-select>
                                            @else
                                                @if ($character->activeUsers()->count() === 1)
                                                    <span>{{ $character->activeUsers()->first()->name }}</span>
                                                @else
                                                    <div>
                                                        <x-select
                                                            wire:model.live="selectedCharacters.{{ $character->id }}.user_id"
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
                                                        </x-select>

                                                        @if (in_array($character->id, $validateSelectedCharacters))
                                                            <p class="ml-0.5 mt-1 text-sm font-medium text-danger-500">
                                                                Select a user to continue
                                                            </p>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endif

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
                                    </x-spacing>
                                @endforeach

                                @foreach ($users as $user)
                                    <x-spacing size="row" class="flex items-center justify-between gap-6">
                                        <div class="w-1/2">
                                            <x-input.text
                                                placeholder="Who is this user playing? (optional)"
                                                wire:model.live.debounce.500ms="selectedUsers.{{ $user->id }}.as"
                                                wire:key="u-{{ $user->id }}-as"
                                            ></x-input.text>
                                        </div>

                                        <div class="flex items-center gap-4">
                                            <span>{{ $user->name }}</span>

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
                                    </x-spacing>
                                @endforeach
                            </div>
                        @else
                            <x-empty-state.small
                                icon="users"
                                title="No authors assigned"
                                message="Add an author to continue writing your post"
                            ></x-empty-state.small>
                        @endif
                    </x-panel>
                </x-panel>
            </x-fieldset>
        </x-form>
    </div>

    <x-slot name="footer">
        <x-button type="button" wire:click="save" color="primary">Update</x-button>
        <x-button type="button" wire:click="close" plain>Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
