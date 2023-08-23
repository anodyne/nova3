{{-- format-ignore-start --}}
<x-panel>
    <x-panel.header
        title="Stories"
        message="Manage the stories and timeline of your game"
    >
        <x-slot name="actions">
            {{--
                @if ($this->stories->count() > 0)
                <x-dropdown placement="bottom-start md:bottom-end">
                <x-slot:trigger leading="filter" color="gray">
                Sort
                </x-slot:trigger>

                <x-dropdown.group>
                <x-dropdown.item :href="route('stories.index', 'sort=asc')">
                <div class="flex items-center justify-between w-full">
                <span>Sort by newest first</span>
                @if (request('sort', 'desc') === 'asc')
                <x-icon name="check" size="sm" class="shrink-0 text-primary-500"></x-icon>
                @endif
                </div>
                </x-dropdown.item>
                <x-dropdown.item :href="route('stories.index', 'sort=desc')">
                <div class="flex items-center justify-between w-full">
                <span>Sort by oldest first</span>
                @if (request('sort', 'desc') === 'desc')
                <x-icon name="check" size="sm" class="shrink-0 text-primary-500"></x-icon>
                @endif
                </div>
                </x-dropdown.item>
                </x-dropdown.group>
                </x-dropdown>
                @endif
            --}}

            @can('create', $storyClass)
                <x-button.filled
                    :href="route('stories.create')"
                    leading="add"
                    color="primary"
                >
                    Add
                </x-button.filled>
            @endcan
        </x-slot>
    </x-panel.header>

    @if ($this->stories->count() === 0)
        <x-empty-state.large
            icon="book"
            :link="route('stories.create')"
            :link-access="gate()->allows('create', $storyClass)"
            label="Create your first story"
            message="Stories live on a timeline to give you and your players incredible flexibility in how you tell your game's adventures."
        ></x-empty-state.large>
    @else
        <div class="sticky top-4">
            <div class="relative w-auto mx-auto z-50 rounded-lg bg-gray-900/90 text-white py-1.5 px-4 flex items-center gap-4">
                <x-icon name="edit"></x-icon>
                <x-icon name="trash"></x-icon>
                <x-icon name="arrow-right"></x-icon>
            </div>
        </div>

        @if ($selectedStory)
            <x-content-box
                height="sm"
                class="sticky top-0 z-30 border-y border-gray-200 bg-gray-50/50 backdrop-blur dark:border-gray-800 dark:bg-gray-700/25 sm:border-t-0"
            >
                <div class="flex items-center justify-between md:hidden">
                    <div
                        class="flex-1 truncate text-xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-lg"
                    >
                        {{ $selectedStory->title }}
                    </div>

                    <div class="flex items-center space-x-4">
                        @can('update', $selectedStory)
                            <span>
                                <livewire:stories:status
                                    :story="$selectedStory"
                                    wire:key="status-{{ $selectedStory->id }}"
                                />
                            </span>
                        @endcan

                        <x-dropdown placement="bottom-end" wide>
                            <x-slot name="trigger">
                                <x-icon.more class="h-7 w-7 md:h-6 md:w-6" />
                            </x-slot>

                            <x-dropdown.group>
                                @can('view', $selectedStory)
                                    <x-dropdown.item
                                        :href="route('stories.show', $selectedStory)"
                                        icon="show"
                                    >
                                        <span>View</span>
                                    </x-dropdown.item>
                                @endcan

                                @can('update', $selectedStory)
                                    <x-dropdown.item
                                        :href="route('stories.edit', $selectedStory)"
                                        icon="edit"
                                    >
                                        <span>Edit</span>
                                    </x-dropdown.item>
                                @endcan
                            </x-dropdown.group>

                            @can('view', $selectedStory)
                                <x-dropdown.group>
                                    <x-dropdown.item icon="list">
                                        <span>Posts</span>
                                    </x-dropdown.item>
                                </x-dropdown.group>
                            @endcan

                            @can('create', $selectedStory)
                                <x-dropdown.group>
                                    <x-dropdown.text
                                        class="font-semibold uppercase tracking-wide text-gray-500"
                                    >
                                        Add a story
                                    </x-dropdown.text>
                                    <x-dropdown.item
                                        :href='route("stories.create", "direction=before&neighbor={$selectedStory->id}")'
                                        icon="move-up"
                                    >
                                        <span>Before this story</span>
                                    </x-dropdown.item>
                                    <x-dropdown.item
                                        :href='route("stories.create", "direction=after&neighbor={$selectedStory->id}")'
                                        icon="move-down"
                                    >
                                        <span>After this story</span>
                                    </x-dropdown.item>
                                    <x-dropdown.item
                                        :href='route("stories.create", "parent={$selectedStory->id}")'
                                        icon="move-right"
                                    >
                                        <span>Inside this story</span>
                                    </x-dropdown.item>
                                </x-dropdown.group>
                            @endcan

                            @can('delete', $selectedStory)
                                <x-dropdown.group>
                                    <x-dropdown.item-danger
                                        :href="route('stories.delete', $selectedStory)"
                                        icon="trash"
                                    >
                                        <span>Delete</span>
                                    </x-dropdown.item-danger>
                                </x-dropdown.group>
                            @endcan
                        </x-dropdown>
                    </div>
                </div>

                <div class="hidden items-center space-x-8 leading-0 md:flex">
                    <span
                        class="font-bold tracking-tight text-gray-900 dark:text-white"
                    >
                        {{ $selectedStory->title }}
                    </span>

                    @can('view', $selectedStory)
                        <x-button.text
                            :href="route('stories.show', $selectedStory)"
                            color="gray"
                            leading="show"
                        >
                            View
                        </x-button.text>
                    @endcan

                    @can('update', $selectedStory)
                        <x-button.text
                            :href="route('stories.edit', $selectedStory)"
                            color="gray"
                            leading="edit"
                        >
                            Edit
                        </x-button.text>
                    @endcan

                    @can('view', $selectedStory)
                        <x-button.text href="#" color="gray" leading="list">
                            Posts
                        </x-button.text>
                    @endcan

                    @can('delete', $selectedStory)
                        <x-button.text
                            :href="route('stories.delete', $selectedStory)"
                            color="gray-danger"
                            leading="trash"
                        >
                            Delete
                        </x-button.text>
                    @endcan

                    @can('create', $selectedStory)
                        <x-dropdown>
                            <x-slot name="trigger" leading="add" color="gray">
                                <div class="flex items-center">
                                    <span>Add story</span>
                                    <x-icon.chevron-down
                                        class="ml-1.5 h-4 w-4 shrink-0"
                                    />
                                </div>
                            </x-slot>

                            <x-dropdown.group>
                                <x-dropdown.item
                                    :href='route("stories.create", "direction=before&neighbor={$selectedStory->id}")'
                                    icon="move-up"
                                >
                                    <span>Before this story</span>
                                </x-dropdown.item>
                                <x-dropdown.item
                                    :href='route("stories.create", "direction=after&neighbor={$selectedStory->id}")'
                                    icon="move-down"
                                >
                                    <span>After this story</span>
                                </x-dropdown.item>
                                <x-dropdown.item
                                    :href='route("stories.create", "parent={$selectedStory->id}")'
                                    icon="move-right"
                                >
                                    <span>Inside this story</span>
                                </x-dropdown.item>
                            </x-dropdown.group>
                        </x-dropdown>
                    @endcan

                    @can('update', $selectedStory)
                        <span>
                            <livewire:stories:status
                                :story="$selectedStory"
                                wire:key="status-{{ $selectedStory->id }}"
                            />
                        </span>
                    @endcan
                </div>
            </x-content-box>
        @endif

        <x-content-box height="xs" width="xs">
            <div class="w-full">
                <x-stories.timeline
                    :stories="$this->stories"
                    :selected-story="$selectedStory"
                />
            </div>
        </x-content-box>
    @endif
</x-panel>
{{-- format-ignore-end --}}
