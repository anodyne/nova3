<x-modal.slide-over title="Manage authors" :icon="Icon::Characters">
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
                            <x-spacing size="2xs">
                                <x-panel.manage.search :search="$search" :placeholder="$authorSearchPlaceholder">
                                    @if ($filteredCharacters->count() > 0)
                                        <x-dropdown.group>
                                            <x-dropdown.header>Characters</x-dropdown.header>

                                            @foreach ($filteredCharacters as $character)
                                                <x-dropdown.item
                                                    type="button"
                                                    wire:click="addCharacterAuthor({{ $character->id }})"
                                                    wire:key="search-c-{{ $character->id }}"
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
                                                <x-dropdown.item
                                                    type="button"
                                                    wire:click="addUserAuthor({{ $user->id }})"
                                                >
                                                    {{ $user->name }}
                                                </x-dropdown.item>
                                            @endforeach
                                        </x-dropdown.group>
                                    @endif

                                    @if ($filteredCharacters->isEmpty() && $filteredUsers->isEmpty())
                                        <x-empty-state.small
                                            :icon="Icon::AlertCircle"
                                            title="No author(s) found"
                                        ></x-empty-state.small>
                                    @endif
                                </x-panel.manage.search>
                            </x-spacing>
                        @endif

                        @if ($characterAuthors->count() > 0 || $userAuthors->count() > 0)
                            <div class="divide-y divide-gray-950/5 dark:divide-white/5">
                                @foreach ($characterAuthors as $characterAuthor)
                                    <x-spacing
                                        size="row"
                                        class="flex items-center justify-between gap-6"
                                        wire:key="ca-{{ $characterAuthor->id }}"
                                    >
                                        <x-avatar.meta
                                            :src="$characterAuthor->avatar_url"
                                            :primary="$characterAuthor->name"
                                            size="xs"
                                        ></x-avatar.meta>

                                        <div class="flex items-center gap-4">
                                            @if ($characterAuthor->type === 'support')
                                                <x-select
                                                    wire:model.live="characterAuthorsPivotData.{{ $characterAuthor->id }}.user_id"
                                                >
                                                    <option value="">Select a user (optional)</option>

                                                    @foreach ($allUsers as $user)
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </x-select>
                                            @else
                                                @if ($characterAuthor->activeUsers->count() === 1)
                                                    <span>{{ $characterAuthor->activeUsers->first()->name }}</span>
                                                @else
                                                    <div>
                                                        <x-select
                                                            wire:model.live="characterAuthorsPivotData.{{ $characterAuthor->id }}.user_id"
                                                        >
                                                            <option value="">Select an assigned user</option>

                                                            @foreach ($characterAuthor->activeUsers as $user)
                                                                <option
                                                                    value="{{ $user->id }}"
                                                                    wire:key="c-{{ $characterAuthor->id }}-u-{{ $user->id }}"
                                                                >
                                                                    {{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                        </x-select>

                                                        @if (in_array($characterAuthor->id, $characterAuthorsValidationErrors))
                                                            <p class="text-danger-500 mt-1 ml-0.5 text-sm font-medium">
                                                                Select a user to continue
                                                            </p>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endif

                                            <x-dropdown placement="bottom end">
                                                <x-slot name="trigger">
                                                    <x-button type="button" color="neutral-danger" size="none" text>
                                                        <x-icon :name="Icon::Trash" size="md"></x-icon>
                                                    </x-button>
                                                </x-slot>

                                                <x-dropdown.group>
                                                    <x-dropdown.text>
                                                        Are you sure you want to remove
                                                        <strong class="font-semibold">
                                                            {{ $characterAuthor->name }}
                                                        </strong>
                                                        as an author of this post?
                                                    </x-dropdown.text>
                                                </x-dropdown.group>

                                                <x-dropdown.group>
                                                    <x-dropdown.item
                                                        type="button"
                                                        :icon="Icon::Trash"
                                                        wire:click="removeCharacterAuthor({{ $characterAuthor->id }})"
                                                        variant="danger"
                                                    >
                                                        Remove
                                                    </x-dropdown.item>
                                                    <x-dropdown.item
                                                        type="button"
                                                        :icon="Icon::Ban"
                                                        x-on:click.prevent="$dispatch('dropdown-close')"
                                                    >
                                                        Cancel
                                                    </x-dropdown.item>
                                                </x-dropdown.group>
                                            </x-dropdown>
                                        </div>
                                    </x-spacing>
                                @endforeach

                                @foreach ($userAuthors as $userAuthor)
                                    <x-spacing size="row" class="flex items-center justify-between gap-6">
                                        <div class="w-1/2">
                                            <x-input.text
                                                placeholder="Who is this user playing? (optional)"
                                                wire:model.blur="userAuthorsPivotData.{{ $userAuthor->id }}.as"
                                                wire:key="u-{{ $userAuthor->id }}-as"
                                            ></x-input.text>
                                        </div>

                                        <div class="flex items-center gap-4">
                                            <span>{{ $userAuthor->name }}</span>

                                            <x-dropdown placement="bottom end">
                                                <x-slot name="trigger">
                                                    <x-button type="button" color="neutral-danger" size="none" text>
                                                        <x-icon :name="Icon::Trash" size="md"></x-icon>
                                                    </x-button>
                                                </x-slot>

                                                <x-dropdown.group>
                                                    <x-dropdown.text>
                                                        Are you sure you want to remove
                                                        <strong class="font-semibold">
                                                            {{ $userAuthor->name }}
                                                        </strong>
                                                        as an author of this post?
                                                    </x-dropdown.text>
                                                </x-dropdown.group>
                                                <x-dropdown.group>
                                                    <x-dropdown.item
                                                        type="button"
                                                        :icon="Icon::Trash"
                                                        wire:click="removeUserAuthor({{ $userAuthor->id }})"
                                                        variant="danger"
                                                    >
                                                        Remove
                                                    </x-dropdown.item>
                                                    <x-dropdown.item
                                                        type="button"
                                                        :icon="Icon::Ban"
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
                                :icon="Icon::Users"
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
        <x-button type="button" wire:click="save" color="primary" :disabled="! $canSave">Update</x-button>
        <x-button type="button" wire:click="$dispatch('slide-over.close')" plain>Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
