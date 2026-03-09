@use('Nova\Characters\Models\Character')
@use('Nova\Stories\Enums\PostSetupMode')
@use('Nova\Stories\Models\Post')
@use('Nova\Stories\Models\PostType')
@use('Nova\Stories\Models\Story')

<x-spacing class="space-y-12" wire:cloak constrained>
    <x-page-heading heading="Write a story post"></x-page-heading>

    <div class="grid gap-12">
        <x-panel variant="well">
            <x-panel.header
                title="Story"
                description="Choose which currently running story you’d like to create your post in."
                :icon="Tabler::Books"
                icon-size="lg"
            >
                @can('manage', Story::class)
                    <x-slot name="actions">
                        <x-button
                            :href="route('admin.stories.index')"
                            variant="subtle"
                            inset="right top bottom"
                            square
                        >
                            <x-icon :name="Tabler::Settings" size="md" />
                        </x-button>
                    </x-slot>
                @endcan
            </x-panel.header>

            <x-panel>
                <x-spacing size="md">
                    @if ($currentStories->count() === 0)
                        <x-empty>
                            <x-illustration :name="Illustration::Book" />
                            <x-empty.heading>No stories available</x-empty.heading>
                            <x-empty.text>
                                There are no actively running stories right now. Update a story to a status of current
                                to allow posting.
                            </x-empty.text>
                        </x-empty>
                    @else
                        <div>
                            <div class="flex items-center gap-2">
                                <x-select wire:model.live="storyId">
                                    <option value="">Choose a story</option>
                                    @foreach ($currentStories as $currentStory)
                                        <option
                                            value="{{ $currentStory->id }}"
                                            wire:key="story-{{ $currentStory->id }}"
                                        >
                                            {{ $currentStory->title }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>

                            @error('storyId')
                                <p class="text-danger-500 mt-1 ml-0.5 text-sm font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </x-spacing>
            </x-panel>
        </x-panel>

        <x-panel variant="well">
            <x-panel.header
                title="Post type"
                description="Post types allow you to control the type of content that can be created inside of stories."
                :icon="Tabler::PencilCog"
                icon-size="lg"
            >
                @can('viewAny', PostType::class)
                    <x-slot name="actions">
                        <x-button
                            :href="route('admin.post-types.index')"
                            variant="subtle"
                            inset="right top bottom"
                            square
                        >
                            <x-icon :name="Tabler::Settings" size="md" />
                        </x-button>
                    </x-slot>
                @endcan
            </x-panel.header>

            <x-panel>
                <x-spacing size="md">
                    @if ($availablePostTypes->count() === 0)
                        <x-empty>
                            <x-illustration :name="Illustration::FlowchartPaper" />
                            <x-empty.heading>No post types available</x-empty.heading>
                            <x-empty.text>
                                You do not have any post types available to you. Please contact a Game Master to add a
                                post type or update an existing post type for you to use.
                            </x-empty.text>
                        </x-empty>
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
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>

                            @error('postTypeId')
                                <p class="text-danger-500 mt-1 ml-0.5 text-sm font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </x-spacing>
            </x-panel>
        </x-panel>

        <x-panel variant="well">
            <x-panel.header
                title="Your author"
                description="Choose which of your active characters you’d like to use as an author on this post. You will be able to add more authors after starting your post."
                :icon="Tabler::UserEdit"
                icon-size="lg"
            >
                @can('createAny', Character::class)
                    <x-slot name="actions">
                        <x-button
                            :href="route('admin.characters.index')"
                            variant="subtle"
                            inset="right top bottom"
                            square
                        >
                            <x-icon :name="Tabler::Settings" size="md" />
                        </x-button>
                    </x-slot>
                @endcan
            </x-panel.header>

            <x-panel>
                <x-spacing size="md">
                    @if ($characters->count() === 0)
                        <x-empty>
                            <x-illustration :name="Illustration::Vulcan" />
                            <x-empty.heading>No active characters</x-empty.heading>
                            <x-empty.text>
                                You do not have any active characters to choose from.

                                @can('createAny', Character::class)
                                    Please create an active character for yourself in order to continue.
                                @endcan

                                @cannot('createAny', Character::class)
                                    Please contact  a Game Master to help you add a character to your account.
                                @endcan
                            </x-empty.text>
                        </x-empty>
                    @else
                        <div>
                            <div class="flex items-center gap-2">
                                <x-select wire:model.live="characterId">
                                    <option value="">Choose a character</option>
                                    @foreach ($characters as $character)
                                        <option
                                            value="{{ $character->id }}"
                                            wire:key="character-{{ $character->id }}"
                                        >
                                            {{ $character->display_name }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>

                            @error('characterId')
                                <p class="text-danger-500 mt-1 ml-0.5 text-sm font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </x-spacing>
            </x-panel>
        </x-panel>
    </div>

    @if ($canContinueWriting)
        <div>
            <x-button wire:click="saveAndContinueWriting" variant="primary">
                Start writing
                <span aria-hidden="true">→</span>
            </x-button>
        </div>
    @endif
</x-spacing>
