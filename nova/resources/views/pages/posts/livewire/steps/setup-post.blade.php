@use('Nova\Stories\Models\PostType')
@use('Nova\Stories\Models\Story')

<x-write-post-wizard-layout
    :steps="$steps"
    message="Choose the story, post type, and any authors for your post to get started"
>
    <x-fieldset>
        <x-fieldset.heading>
            <x-icon name="books"></x-icon>
            <x-fieldset.legend>Story</x-fieldset.legend>
            <x-fieldset.description>
                Choose which currently running story you’d like to create your post in.
            </x-fieldset.description>
        </x-fieldset.heading>

        <x-fieldset.field-group constrained>
            @if ($currentStories->count() === 0)
                <x-empty-state.small
                    icon="books"
                    title="No stories available"
                    message="There are no actively running stories right now. Update a story to a status of current to allow posting."
                    :link="route('admin.stories.index')"
                    label="Manage stories &rarr;"
                    :link-access="gate()->allows('viewAny', Story::class)"
                ></x-empty-state.small>
            @else
                <div>
                    <div class="flex items-center gap-2">
                        <x-select wire:model.live="storyId">
                            <option value="">Choose a story</option>
                            @foreach ($currentStories as $currentStory)
                                <option value="{{ $currentStory->id }}" wire:key="story-{{ $currentStory->id }}">
                                    {{ $currentStory->title }}

                                    @if ($currentStory?->status->name() !== 'current')
                                            ({{ $currentStory->status->displayName() }})
                                    @endif
                                </option>
                            @endforeach
                        </x-select>

                        @can('viewAny', Nova\Stories\Models\Story::class)
                            <x-button :href="route('admin.stories.index')" color="neutral" text>
                                <x-icon name="settings" size="md"></x-icon>
                            </x-button>
                        @endcan
                    </div>

                    <x-text class="mt-2">{{ $story?->description }}</x-text>
                </div>

                @if (isset($story) && $story->status->name() !== 'current')
                    <div class="mt-4 max-w-xl">
                        <x-panel.warning title="Non-current story selected" icon="warning">
                            <strong class="font-semibold">{{ $story->title }}</strong>
                            is a {{ $story->status->name() }} story. You can update the post to a currently running
                            story or leave it assigned to this story. If you change the story this post is assigned to,
                            you will not be able to assign it back to {{ $story->title }} without the help of a game
                            master.
                        </x-panel.warning>
                    </div>
                @endif
            @endif
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading>
            <x-icon name="edit-settings"></x-icon>
            <x-fieldset.legend>Post type</x-fieldset.legend>
            <x-fieldset.description>
                Post types allow you to control the type of content that can create inside of stories.
            </x-fieldset.description>
        </x-fieldset.heading>

        <x-fieldset.field-group constrained>
            @if ($availablePostTypes->count() === 0)
                <x-empty-state.small
                    icon="edit-settings"
                    title="No post types available"
                    message="You do not have any post types available to you. Please contact a game master to add a post type or update an existing post type to use."
                    :link="route('admin.post-types.index')"
                    label="Manage post types"
                    :link-access="gate()->allows('viewAny', PostType::class)"
                ></x-empty-state.small>
            @else
                <div>
                    <div class="flex items-center gap-2">
                        <x-select wire:model.live="postTypeId">
                            <option value="">Choose a post type</option>
                            @foreach ($availablePostTypes as $availablePostType)
                                <option
                                    value="{{ $availablePostType->id }}"
                                    wire:key="post-type-{{ $availablePostType->id }}"
                                >
                                    {{ $availablePostType->name }}

                                    @if ($availablePostType?->trashed())
                                        (Deleted)
                                    @endif
                                </option>
                            @endforeach
                        </x-select>

                        @can('viewAny', Nova\Stories\Models\PostType::class)
                            <x-button :href="route('admin.post-types.index')" color="neutral" text>
                                <x-icon name="settings" size="md"></x-icon>
                            </x-button>
                        @endcan
                    </div>

                    <x-text class="mt-2">
                        {{ $postType?->description }}
                    </x-text>
                </div>

                @if (isset($postType) && $postType->trashed())
                    <div class="mt-4 max-w-xl">
                        <x-panel.danger title="Deleted post type selected" icon="alert">
                            The
                            <strong class="font-semibold">{{ $postType->name }}</strong>
                            post type has been deleted. You can update the post to a different post type or leave it
                            assigned to this post type. If you change the post type, you will not be able to assign it
                            back to {{ $postType->name }} without the help of a game master.
                        </x-panel.danger>
                    </div>
                @endif
            @endif
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading>
            <x-icon name="users"></x-icon>
            <x-fieldset.legend>Authors</x-fieldset.legend>
            <x-fieldset.description>
                Any character on the manifest can be added as an author. If the character is assigned to multiple users,
                you can select which user will be playing the character. If the character is a support character, you
                can assign any users to play that character.

                <x-fieldset.description class="mt-4">
                    Users can also be added as authors to allow collaborative writing with characters that may not be on
                    the manifest or may be story specific.
                </x-fieldset.description>
            </x-fieldset.description>
        </x-fieldset.heading>

        <x-fieldset.field-group>
            @if (blank($postType))
                <x-empty-state.small
                    icon="warning"
                    title="No post type selected"
                    message="Post types determine the type and quantity of authors that can be selected. Please select a post type to manage authors for your post."
                ></x-empty-state.small>
            @else
                <x-panel well>
                    <x-spacing size="sm">
                        <x-fieldset.legend>Choose your authors</x-fieldset.legend>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <x-panel.manage>
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
                                            icon="alert"
                                            title="No author(s) found"
                                        ></x-empty-state.small>
                                    @endif
                                </x-panel.manage.search>
                            @endif

                            @if ($characters->count() > 0 || $users->count() > 0)
                                <div
                                    @class([
                                        'divide-y divide-gray-950/5 rounded-b-lg dark:divide-white/5',
                                        'border-t border-gray-950/5 dark:border-white/5' => $canAddAuthors,
                                    ])
                                >
                                    @foreach ($characters as $character)
                                        <x-spacing
                                            height="xs"
                                            width="sm"
                                            class="flex items-center justify-between gap-6"
                                        >
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
                                                                <p
                                                                    class="ml-0.5 mt-1 text-sm font-medium text-danger-500"
                                                                >
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
                                                            <strong
                                                                class="font-semibold text-gray-700 dark:text-gray-200"
                                                            >
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
                                        <x-spacing
                                            height="xs"
                                            width="sm"
                                            class="flex items-center justify-between gap-6"
                                        >
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
                                                            <strong
                                                                class="font-semibold text-gray-700 dark:text-gray-200"
                                                            >
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
                                <div class="border-t border-gray-950/5 dark:border-white/5">
                                    <x-empty-state.small
                                        icon="users"
                                        title="No authors assigned"
                                        message="Add an author to continue writing your post"
                                    ></x-empty-state.small>
                                </div>
                            @endif
                        </x-panel.manage>
                    </x-spacing>
                </x-panel>
            @endif
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset.controls>
        @if ($canGoToNextStep)
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-x-2">
                    <x-button wire:click="goToNextStep" color="primary">Next: Write post &rarr;</x-button>

                    @if ($post->exists)
                        <x-button wire:click="save" color="neutral">Save</x-button>
                    @endif
                </div>

                @canany(['discardDraft', 'delete'], $post)
                    <div class="flex items-center">
                        @can('discardDraft', $post)
                            <x-dropdown placement="bottom-start">
                                <x-slot name="trigger" color="neutral-danger" leading="trash">Discard draft</x-slot>

                                <x-dropdown.group>
                                    <x-dropdown.text>
                                        Are you sure you want to discard this {{ str($postType?->name)->lower() }}
                                        draft?
                                    </x-dropdown.text>
                                </x-dropdown.group>
                                <x-dropdown.group>
                                    <x-dropdown.item-danger
                                        type="button"
                                        icon="trash"
                                        wire:click="discardDraft({{ $post?->id }})"
                                    >
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
                                <x-slot name="trigger" color="neutral-danger" leading="trash">
                                    Delete {{ str($postType->name)->lower() }}
                                </x-slot>

                                <x-dropdown.group>
                                    <x-dropdown.text>
                                        Are you sure you want to delete this {{ str($postType?->name)->lower() }}?
                                    </x-dropdown.text>
                                </x-dropdown.group>
                                <x-dropdown.group>
                                    <x-dropdown.item-danger
                                        type="button"
                                        icon="trash"
                                        wire:click="deletePost({{ $post?->id }})"
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
                        @endcan
                    </div>
                @endcanany
            </div>
        @else
            <x-panel.warning class="w-full">
                {{ $canGoToNextStepMessage }}
            </x-panel.warning>
        @endif
    </x-fieldset.controls>
</x-write-post-wizard-layout>
