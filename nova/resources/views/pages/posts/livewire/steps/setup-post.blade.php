<x-write-post-wizard-layout
    :steps="$steps"
    message="Choose the story, post type, and any authors for your post to get started"
>
    <div class="divide-y divide-gray-200 dark:divide-gray-800">
        <div class="grid grid-cols-3 gap-8">
            <x-content-box class="space-y-2">
                <x-h2>Story</x-h2>
                <x-text>Choose which currently running story you’d like to create your post in.</x-text>
            </x-content-box>
            <x-content-box class="col-span-2">
                @if ($currentStories->count() === 0)
                    <x-empty-state.small
                        icon="book"
                        title="No stories available"
                        message="There are no actively running stories right now. Update a story to a status of current to allow posting."
                        :link="route('stories.index')"
                        label="Manage stories"
                        :link-access="gate()->allows('viewAny', Nova\Stories\Models\Story::class)"
                    ></x-empty-state.small>
                @else
                    <div class="flex w-1/2 items-center gap-2">
                        <x-input.select wire:model.live="storyId">
                            <option value="">Choose a story</option>
                            @foreach ($currentStories as $currentStory)
                                <option value="{{ $currentStory->id }}" wire:key="story-{{ $currentStory->id }}">
                                    {{ $currentStory->title }}

                                    @if ($currentStory?->status->name() !== 'current')
                                            ({{ $currentStory->status->displayName() }})
                                    @endif
                                </option>
                            @endforeach
                        </x-input.select>

                        @can('viewAny', Nova\Stories\Models\Story::class)
                            <x-button.text :href="route('stories.index')" color="subtle-neutral">
                                <x-icon name="settings" size="md"></x-icon>
                            </x-button.text>
                        @endcan
                    </div>

                    <p class="mt-2 max-w-xl text-sm/6 text-gray-600 dark:text-gray-400">{{ $story?->description }}</p>

                    @if (isset($story) && $story->status->name() !== 'current')
                        <div class="mt-4 max-w-xl">
                            <x-panel.warning title="Non-current story selected" icon="warning">
                                <strong class="font-semibold">{{ $story->title }}</strong>
                                is a {{ $story->status->name() }} story. You can update the post to a currently running
                                story or leave it assigned to this story. If you change the story this post is assigned
                                to, you will not be able to assign it back to {{ $story->title }} without the help of a
                                game master.
                            </x-panel.warning>
                        </div>
                    @endif
                @endif
            </x-content-box>
        </div>

        <div class="grid grid-cols-3 gap-8">
            <x-content-box class="space-y-2">
                <x-h2>Post type</x-h2>
                <x-text>Post types allow you to control the type of content that can create inside of stories.</x-text>
            </x-content-box>
            <x-content-box class="col-span-2">
                @if ($availablePostTypes->count() === 0)
                    <x-empty-state.small
                        icon="edit-settings"
                        title="No post types available"
                        message="You do not have any post types available to you. Please contact a game master to add a post type or update an existing post type to use."
                        :link="route('post-types.index')"
                        label="Manage post types"
                        :link-access="gate()->allows('viewAny', Nova\Stories\Models\PostType::class)"
                    ></x-empty-state.small>
                @else
                    <div class="flex w-1/2 items-center gap-2">
                        <x-input.select wire:model.live="postTypeId">
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
                        </x-input.select>

                        @can('viewAny', Nova\Stories\Models\PostType::class)
                            <x-button.text :href="route('post-types.index')" color="subtle-neutral">
                                <x-icon name="settings" size="md"></x-icon>
                            </x-button.text>
                        @endcan
                    </div>

                    <p class="mt-2 max-w-xl text-sm/6 text-gray-600 dark:text-gray-400">
                        {{ $postType?->description }}
                    </p>

                    @if (isset($postType) && $postType->trashed())
                        <div class="mt-4 max-w-xl">
                            <x-panel.danger title="Deleted post type selected" icon="alert">
                                The
                                <strong class="font-semibold">{{ $postType->name }}</strong>
                                post type has been deleted. You can update the post to a different post type or leave it
                                assigned to this post type. If you change the post type, you will not be able to assign
                                it back to {{ $postType->name }} without the help of a game master.
                            </x-panel.danger>
                        </div>
                    @endif
                @endif
            </x-content-box>
        </div>

        <div class="grid grid-cols-3 gap-8">
            <x-content-box class="space-y-2">
                <x-h2>Authors</x-h2>
                <div class="space-y-4 text-sm/6 text-gray-600 dark:text-gray-400">
                    <x-text>
                        Any character on the manifest can be added as an author. If the character is assigned to
                        multiple users, you can select which user will be playing the character. If the character is a
                        support character, you can assign any users to play that character.
                    </x-text>

                    <x-text>
                        Users can also be added as authors to allow collaborative writing with characters that may not
                        be on the manifest or may be story specific.
                    </x-text>
                </div>
            </x-content-box>
            <x-content-box class="col-span-2">
                @if (blank($postType))
                    <div class="w-1/2">
                        <x-empty-state.small
                            icon="warning"
                            title="No post type selected"
                            message="Post types determine the type and quantity of authors that can be selected. Please select a post type to manage authors for your post."
                        ></x-empty-state.small>
                    </div>
                @else
                    <x-panel>
                        @if ($canAddAuthors)
                            <x-content-box height="xs" width="xs" class="rounded-t-lg bg-gray-50 dark:bg-gray-950/30">
                                <div class="flex justify-between space-x-4">
                                    <div class="relative w-full">
                                        <x-input.group>
                                            <x-input.text
                                                wire:model.live.debounce.500ms="search"
                                                :placeholder="$authorSearchPlaceholder"
                                            >
                                                <x-slot name="leading">
                                                    <x-icon name="search" size="sm"></x-icon>
                                                </x-slot>

                                                <x-slot name="trailing">
                                                    @if (filled($search))
                                                        <x-button.text
                                                            tag="button"
                                                            color="neutral"
                                                            wire:click="$set('search', '')"
                                                        >
                                                            <x-icon name="x" size="sm"></x-icon>
                                                        </x-button.text>
                                                    @endif
                                                </x-slot>
                                            </x-input.text>
                                        </x-input.group>

                                        @if (filled($search))
                                            <div
                                                class="absolute z-10 mt-2 max-h-60 w-full divide-y divide-gray-200 overflow-y-scroll rounded-md bg-white shadow-lg ring-1 ring-gray-950/5 dark:divide-gray-600/50 dark:bg-gray-800"
                                            >
                                                @if ($filteredCharacters->count() > 0)
                                                    <x-dropdown.group>
                                                        <x-dropdown.header>Characters</x-dropdown.header>

                                                        @foreach ($filteredCharacters as $character)
                                                            <x-dropdown.item
                                                                type="button"
                                                                class="group flex w-full items-center rounded-md px-4 py-2 text-base font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none md:text-sm dark:text-gray-300 dark:hover:bg-gray-600/50"
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
                                                                class="group flex w-full items-center rounded-md px-4 py-2 text-base font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none md:text-sm dark:text-gray-300 dark:hover:bg-gray-600/50"
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
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </x-content-box>
                        @endif

                        @if ($characters->count() > 0 || $users->count() > 0)
                            <div
                                @class([
                                    'divide-y divide-gray-200 rounded-b-lg dark:divide-gray-800',
                                    'border-t border-gray-200 dark:border-gray-800' => $canAddAuthors,
                                ])
                            >
                                @foreach ($characters as $character)
                                    <x-content-box
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
                                                <x-input.select
                                                    wire:model.live="selectedCharacters.{{ $character->id }}.user_id"
                                                >
                                                    <option value="">Select a user (optional)</option>
                                                    @foreach ($allUsers as $user)
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </x-input.select>
                                            @else
                                                @if ($character->activeUsers()->count() === 1)
                                                    <span>{{ $character->activeUsers()->first()->name }}</span>
                                                @else
                                                    <div>
                                                        <x-input.select
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
                                                        </x-input.select>

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
                                    </x-content-box>
                                @endforeach

                                @foreach ($users as $user)
                                    <x-content-box
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
                                    </x-content-box>
                                @endforeach
                            </div>
                        @else
                            <div class="border-t border-gray-200 dark:border-gray-800">
                                <x-empty-state.small
                                    icon="users"
                                    title="No authors assigned"
                                    message="Add an author to continue writing your post"
                                ></x-empty-state.small>
                            </div>
                        @endif
                    </x-panel>
                @endif
            </x-content-box>
        </div>
    </div>

    <div
        @class([
            'flex flex-col rounded-b-lg border-t border-gray-200 px-4 py-4 md:flex-row md:items-center md:justify-between md:px-6 md:py-6 dark:border-gray-800',
            'bg-gray-50 font-medium text-gray-500 dark:bg-gray-950/30' => ! $canGoToNextStep,
        ])
    >
        <div class="flex items-center">
            @can('discardDraft', $post)
                <x-dropdown placement="bottom-start">
                    <x-slot name="trigger" color="neutral-danger" leading="trash" size="none">Discard draft</x-slot>

                    <x-dropdown.group>
                        <x-dropdown.text>
                            Are you sure you want to discard this {{ str($postType?->name)->lower() }} draft?
                        </x-dropdown.text>
                    </x-dropdown.group>
                    <x-dropdown.group>
                        <x-dropdown.item-danger type="button" icon="trash" wire:click="discardDraft({{ $post?->id }})">
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
                    <x-slot name="trigger" color="neutral-danger" leading="trash" size="none">
                        Delete {{ str($postType->name)->lower() }}
                    </x-slot>

                    <x-dropdown.group>
                        <x-dropdown.text>
                            Are you sure you want to delete this {{ str($postType?->name)->lower() }}?
                        </x-dropdown.text>
                    </x-dropdown.group>
                    <x-dropdown.group>
                        <x-dropdown.item-danger type="button" icon="trash" wire:click="deletePost({{ $post?->id }})">
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
            @if ($canGoToNextStep)
                @if ($post->exists)
                    <x-button.filled wire:click="save" color="neutral">Save</x-button.filled>
                @endif

                <x-button.outlined wire:click="goToNextStep" color="primary">Next: Write post &rarr;</x-button.outlined>
            @else
                {{ $canGoToNextStepMessage }}
            @endif
        </div>
    </div>
</x-write-post-wizard-layout>
