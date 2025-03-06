@use('Nova\Stories\Models\PostType')
@use('Nova\Stories\Models\Story')
@use('Illuminate\Support\Js')

<div>
    @if ($postSetupComplete)
        <div class="grid gap-12 lg:grid-cols-3">
            <div class="space-y-12 lg:col-span-2">
                <div class="space-y-6">
                    <div class="flex items-center gap-x-2">
                        <div class="-ml-2 shrink text-sm/6 font-medium">
                            <x-dropdown.breadcrumb>
                                @if ($currentStories->count() >= 2)
                                    <x-slot name="trigger">
                                        <x-metadata label="Story" :value="$story->title"></x-metadata>
                                    </x-slot>
                                @else
                                    <x-slot name="placeholder">
                                        <x-metadata label="Story" :value="$story->title"></x-metadata>
                                    </x-slot>
                                @endif

                                @foreach ($currentStories as $currentStory)
                                    <x-dropdown.breadcrumb.item wire:click="$set('story_id', {{ $currentStory->id }})">
                                        {{ $currentStory->title }}
                                    </x-dropdown.breadcrumb.item>
                                @endforeach
                            </x-dropdown.breadcrumb>
                        </div>

                        <div class="text-sm/6 font-medium text-gray-400 dark:text-gray-600">/</div>

                        <div class="shrink text-sm/6 font-medium">
                            <x-dropdown.breadcrumb>
                                @if ($availablePostTypes->count() >= 2)
                                    <x-slot name="trigger">
                                        <x-metadata label="Post type" :value="$this->postType->name"></x-metadata>
                                    </x-slot>
                                @else
                                    <x-slot name="placeholder">
                                        <x-metadata label="Post type" :value="$this->postType->name"></x-metadata>
                                    </x-slot>
                                @endif

                                @foreach ($availablePostTypes as $availablePostType)
                                    <x-dropdown.breadcrumb.item
                                        wire:click="$set('post_type_id', {{ $availablePostType->id }})"
                                        :selected="$availablePostType->id === $post_type_id"
                                    >
                                        <div class="flex items-center gap-x-1.5">
                                            <div class="shrink-0 text-gray-400 dark:text-gray-600">
                                                <x-icon :name="$availablePostType->icon" size="sm"></x-icon>
                                            </div>

                                            <div>{{ $availablePostType->name }}</div>
                                        </div>
                                    </x-dropdown.breadcrumb.item>
                                @endforeach
                            </x-dropdown.breadcrumb>
                        </div>
                    </div>

                    @if ($postType->fields->title->enabled)
                        <div>
                            <input
                                type="text"
                                wire:model.blur="title"
                                class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 text-3xl font-extrabold tracking-tight text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-0 dark:border-white/5 dark:text-gray-100"
                                placeholder="Add a title"
                            />
                        </div>
                    @endif

                    @if ($postType->fields->location->enabled || $postType->fields->day->enabled || $postType->fields->time->enabled)
                        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:space-x-4 md:space-y-0">
                            @if ($postType->fields->location->enabled)
                                <div class="flex flex-1 items-center gap-2">
                                    <x-icon name="location" size="sm" class="text-gray-500"></x-icon>
                                    <input
                                        type="text"
                                        wire:model.blur="location"
                                        class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 font-medium text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-0 dark:text-gray-300"
                                        placeholder="Add a location"
                                    />
                                </div>
                            @endif

                            @if ($postType->fields->day->enabled)
                                <div class="flex flex-1 items-center gap-2">
                                    <x-icon name="calendar" size="sm" class="text-gray-500"></x-icon>
                                    <input
                                        type="text"
                                        wire:model.blur="day"
                                        class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 font-medium text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-0 dark:text-gray-300"
                                        placeholder="Add a day"
                                    />
                                </div>
                            @endif

                            @if ($postType->fields->time->enabled)
                                <div class="flex flex-1 items-center gap-2">
                                    <x-icon name="clock" size="sm" class="text-gray-500"></x-icon>
                                    <input
                                        type="text"
                                        wire:model.blur="time"
                                        class="block w-full flex-1 appearance-none border-none bg-transparent p-0.5 font-medium text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-0 dark:text-gray-300"
                                        placeholder="Add a time"
                                    />
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                @if ($postType->fields->content->enabled)
                    <div x-cloak>
                        <x-editor wire:model="content"></x-editor>
                    </div>
                @endif

                <div class="flex items-center gap-x-2">
                    @if ($postIsDirty)
                        <x-panel variant="well" color="warning">
                            <x-spacing height="3xs" left="3xs" right="sm" class="flex items-center gap-x-3">
                                <x-button wire:click="save" color="warning">Save</x-button>
                                <x-text color="warning" class="font-medium">
                                    There are unsaved changes to your post
                                </x-text>
                            </x-spacing>
                        </x-panel>
                    @else
                        <x-spacing height="3xs" left="3xs" right="sm">
                            <x-button wire:click="save">Save</x-button>
                        </x-spacing>
                    @endif
                </div>

                @env('local')
                    <x-panel variant="well">
                        <x-panel.header title="Debug"></x-panel.header>

                        <x-panel>
                            <x-spacing size="md">
                                <pre
                                    class="rounded-lg bg-gray-100 p-4 font-mono text-sm"
                                >@json($this, JSON_PRETTY_PRINT)</pre>
                            </x-spacing>
                        </x-panel>
                    </x-panel>
                @endenv
            </div>

            <div>
                <div class="space-y-12">
                    <div class="block">
                        <flux:accordion>
                            <flux:accordion.item expanded>
                                <flux:accordion.heading>
                                    <div class="flex items-center gap-x-2">
                                        <x-icon name="characters" size="sm"></x-icon>
                                        <span>Authors</span>
                                    </div>
                                </flux:accordion.heading>

                                <flux:accordion.content>
                                    <div class="space-y-4">
                                        <ul>
                                            @foreach ($characterAuthors as $characterAuthor)
                                                <li
                                                    class="rounded-lg px-3 py-1 odd:bg-gray-950/[.04] dark:odd:bg-white/[.07]"
                                                >
                                                    <div class="text-sm/6 font-medium text-gray-950 dark:text-white">
                                                        {{ $characterAuthor->display_name }}
                                                    </div>
                                                    <div class="text-xs/5">
                                                        played by
                                                        {{ $characterAuthor->postAuthors->first()?->user?->name ?? 'Unassigned' }}
                                                    </div>
                                                </li>
                                            @endforeach

                                            @foreach ($users as $userAuthor)
                                                <li
                                                    class="rounded-lg px-3 py-1 odd:bg-gray-950/[.04] dark:odd:bg-white/[.07]"
                                                >
                                                    <div class="text-sm/6 font-medium text-gray-950 dark:text-white">
                                                        {{ $userAuthor->pivot?->as ?? 'Additional character' }}
                                                    </div>
                                                    <div class="text-xs/5">played by {{ $userAuthor->name }}</div>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <x-button
                                            wire:click="$dispatch('slide-over.open', {
                                                component: 'posts-manage-authors',
                                                arguments: {
                                                    'postId': {{ Js::from($post->id ) }},
                                                    'incomingCharacters': {{ Js::from($characterAuthorPivotData ?? []) }},
                                                    'incomingUsers': {{ Js::from($selectedUsers) }}
                                                }
                                            })"
                                            plain
                                        >
                                            Manage authors &rarr;
                                        </x-button>
                                    </div>
                                </flux:accordion.content>
                            </flux:accordion.item>

                            @if ($postType->fields->rating->enabled)
                                <flux:accordion.item expanded>
                                    <flux:accordion.heading>
                                        <div class="flex items-center gap-x-2">
                                            <x-icon name="mature" size="sm"></x-icon>
                                            <span>Content ratings</span>
                                        </div>
                                    </flux:accordion.heading>

                                    <flux:accordion.content>
                                        <flux:modal.trigger name="edit-rating">
                                            <button
                                                type="button"
                                                class="flex items-center gap-x-3 rounded-lg px-3 py-2 hover:bg-gray-950/5"
                                            >
                                                <x-rating.compact
                                                    label="L"
                                                    :value="$rating_language"
                                                ></x-rating.compact>
                                                <x-rating.compact label="S" :value="$rating_sex"></x-rating.compact>
                                                <x-rating.compact
                                                    label="V"
                                                    :value="$rating_violence"
                                                ></x-rating.compact>
                                            </button>
                                        </flux:modal.trigger>
                                    </flux:accordion.content>
                                </flux:accordion.item>
                            @endif

                            @if ($postType->fields->summary->enabled)
                                <flux:accordion.item expanded>
                                    <flux:accordion.heading>
                                        <div class="flex items-center gap-x-2">
                                            <x-icon name="blockquote" size="sm"></x-icon>
                                            <span>Summary</span>
                                        </div>
                                    </flux:accordion.heading>

                                    <flux:accordion.content>
                                        <flux:modal.trigger name="edit-rating">
                                            <x-button plain>Update summary &rarr;</x-button>
                                        </flux:modal.trigger>
                                    </flux:accordion.content>
                                </flux:accordion.item>
                            @endif

                            <flux:accordion.item expanded>
                                <flux:accordion.heading>
                                    <div class="flex items-center gap-x-2">
                                        <x-icon name="timeline" size="sm"></x-icon>
                                        <span>Post position</span>
                                    </div>
                                </flux:accordion.heading>

                                <flux:accordion.content>
                                    <div class="space-y-4">
                                        <ul role="list" class="space-y-4">
                                            @if (filled($previousPost))
                                                <li class="relative flex gap-x-4">
                                                    <div
                                                        class="absolute -bottom-6 left-0 top-0 flex w-6 justify-center"
                                                    >
                                                        <div class="w-px bg-gray-200"></div>
                                                    </div>

                                                    <div
                                                        class="relative flex size-6 flex-none items-center justify-center bg-white"
                                                    >
                                                        <div
                                                            class="size-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"
                                                        ></div>
                                                    </div>

                                                    <div class="flex flex-auto flex-col py-0.5 text-xs/5 text-gray-500">
                                                        <p class="font-medium text-gray-900">
                                                            {{ $previousPost->title }}
                                                        </p>
                                                        <p class="italic">{{ $previousPost->location_day_time }}</p>
                                                    </div>
                                                </li>
                                            @endif

                                            <li class="relative flex gap-x-4">
                                                @if (filled($nextPost))
                                                    <div
                                                        class="absolute -bottom-6 left-0 top-0 flex w-6 justify-center"
                                                    >
                                                        <div class="w-px bg-gray-200"></div>
                                                    </div>
                                                @endif

                                                <div
                                                    class="relative flex size-6 flex-none items-center justify-center bg-white"
                                                >
                                                    <div
                                                        class="size-1.5 rounded-full bg-primary-100 ring-1 ring-primary-300"
                                                    ></div>
                                                </div>

                                                <div class="flex flex-auto flex-col py-0.5 text-xs/5 text-gray-500">
                                                    <p class="font-medium text-gray-900">
                                                        {{ $title ?? 'This post' }}
                                                    </p>
                                                    <p class="italic">
                                                        {{ collect([$location, $day, $time])->filter()->join(', ') }}
                                                    </p>
                                                </div>
                                            </li>

                                            @if (filled($nextPost))
                                                <li class="relative flex gap-x-4">
                                                    <div
                                                        class="relative flex size-6 flex-none items-center justify-center bg-white"
                                                    >
                                                        <div
                                                            class="size-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"
                                                        ></div>
                                                    </div>

                                                    <div class="flex flex-auto flex-col py-0.5 text-xs/5 text-gray-500">
                                                        <p class="font-medium text-gray-900">{{ $nextPost->title }}</p>
                                                        <p class="italic">{{ $nextPost->location_day_time }}</p>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>

                                        <x-button plain>Update position &rarr;</x-button>
                                    </div>
                                </flux:accordion.content>
                            </flux:accordion.item>
                        </flux:accordion>
                    </div>

                    <div class="space-y-4">
                        <x-button
                            class="w-full"
                            wire:click="$dispatch('slide-over.open', {component: 'posts-publish', arguments: {'post': {{ $post->id }}}})"
                            color="primary"
                        >
                            Publish post &rarr;
                        </x-button>

                        <x-button class="w-full" plain>
                            <x-icon name="trash" size="sm"></x-icon>
                            <span>Discard draft</span>
                        </x-button>
                    </div>
                </div>
            </div>
        </div>

        <flux:modal name="edit-rating" class="w-full space-y-6 md:max-w-xl">
            <x-filament.modal-content :action="null" title="Update content ratings" color="primary" icon="mature">
                <x-fieldset.field label="Language" id="rating_language" name="rating_language">
                    <livewire:rating area="language" wire:model.live="rating_language" />
                </x-fieldset.field>

                <x-fieldset.field label="Sex" id="rating_sex" name="rating_sex">
                    <livewire:rating area="sex" wire:model.live="rating_sex" />
                </x-fieldset.field>

                <x-fieldset.field label="Violence" id="rating_violence" name="rating_violence">
                    <livewire:rating area="violence" wire:model.live="rating_violence" />
                </x-fieldset.field>
            </x-filament.modal-content>

            <div class="flex">
                <x-button type="button" color="primary" x-on:click="$flux.modal('edit-rating').close()">
                    Update
                </x-button>
            </div>
        </flux:modal>
    @else
        <x-spacing class="space-y-12" constrained>
            <x-page-header
                heading="Compose a new post"
                description="Enter a title and pick a story and post type to begin writing your post"
            ></x-page-header>

            <div class="grid gap-12">
                <x-panel variant="well">
                    <x-panel.header
                        title="Story"
                        description="Choose which currently running story you’d like to create your post in."
                        icon="books"
                        icon-size="lg"
                    >
                        @can('viewAny', Story::class)
                            <x-slot name="actions">
                                <x-button :href="route('admin.stories.index')" color="neutral" text>
                                    <x-icon name="settings" size="md"></x-icon>
                                </x-button>
                            </x-slot>
                        @endcan
                    </x-panel.header>

                    <x-panel>
                        <x-spacing size="md">
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
                                        <x-select wire:model.live="story_id">
                                            <option value="">Choose a story</option>
                                            @foreach ($currentStories as $currentStory)
                                                <option
                                                    value="{{ $currentStory->id }}"
                                                    wire:key="story-{{ $currentStory->id }}"
                                                >
                                                    {{ $currentStory->title }}

                                                    @if ($currentStory?->status->name() !== 'current')
                                                            ({{ $currentStory->status->getLabel() }})
                                                    @endif
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                </div>

                                @if (isset($post?->story) && $post?->story?->status->name() !== 'current')
                                    <div class="mt-4 max-w-xl">
                                        <x-panel.warning
                                            title="Non-current story selected"
                                            icon="warning"
                                            icon-size="xl"
                                        >
                                            <x-slot name="description">
                                                <strong class="font-semibold">{{ $post?->story?->title }}</strong>
                                                is a {{ $post?->story?->status->name() }} story. You can update the
                                                post to a currently running story or leave it assigned to this story. If
                                                you change the story this post is assigned to, you will not be able to
                                                assign it back to {{ $post?->story?->title }} without the help of a
                                                game master.
                                            </x-slot>
                                        </x-panel.warning>
                                    </div>
                                @endif
                            @endif
                        </x-spacing>
                    </x-panel>
                </x-panel>

                <x-panel variant="well">
                    <x-panel.header
                        title="Post type"
                        description="Post types allow you to control the type of content that can create inside of stories."
                        icon="edit-settings"
                        icon-size="lg"
                    >
                        @can('viewAny', PostType::class)
                            <x-slot name="actions">
                                <x-button :href="route('admin.post-types.index')" color="neutral" text>
                                    <x-icon name="settings" size="md"></x-icon>
                                </x-button>
                            </x-slot>
                        @endcan
                    </x-panel.header>

                    <x-panel>
                        <x-spacing size="md">
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
                                        <x-select wire:model.live="post_type_id">
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
                                    </div>
                                </div>

                                @if (isset($post?->postType) && $post?->postType->trashed())
                                    <div class="mt-4 max-w-xl">
                                        <x-panel.danger title="Deleted post type selected" icon="alert" icon-size="xl">
                                            <x-slot name="description">
                                                The
                                                <strong class="font-semibold">{{ $post?->postType?->name }}</strong>
                                                post type has been deleted. You can update the post to a different post
                                                type or leave it assigned to this post type. If you change the post
                                                type, you will not be able to assign it back to
                                                {{ $post?->postType?->name }} without the help of a game master.
                                            </x-slot>
                                        </x-panel.danger>
                                    </div>
                                @endif
                            @endif
                        </x-spacing>
                    </x-panel>
                </x-panel>

                <x-panel variant="well">
                    <x-panel.header
                        title="Your author"
                        description="Choose which of your active characters you’d like to use as an author on this post."
                        icon="user-edit"
                        icon-size="lg"
                    ></x-panel.header>

                    <x-panel>
                        <x-spacing size="md">
                            @if ($myCharacters->count() === 0)
                                <x-empty-state.small
                                    icon="edit-settings"
                                    title="No active characters available"
                                    message="You do not have any active characters to choose from."
                                    :link="route('admin.post-types.index')"
                                    label="Manage post types"
                                    :link-access="gate()->allows('viewAny', PostType::class)"
                                ></x-empty-state.small>
                            @else
                                <div>
                                    <div class="flex items-center gap-2">
                                        <x-select wire:change="setupAuthorForNewPost($event.target.value)">
                                            <option value="">Choose a character</option>
                                            @foreach ($myCharacters as $character)
                                                <option
                                                    value="{{ $character->id }}"
                                                    wire:key="character-{{ $character->id }}"
                                                >
                                                    {{ $character->display_name }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                </div>
                            @endif
                        </x-spacing>
                    </x-panel>
                </x-panel>
            </div>
        </x-spacing>
    @endif
</div>
