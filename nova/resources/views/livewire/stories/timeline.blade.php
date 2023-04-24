<x-panel>
    <x-panel.header title="Stories" message="Manage the stories and timeline of your game">
        <x-slot:actions>
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
                                    @icon('check', 'h-6 w-6 md:h-5 md:w-5 shrink-0 text-primary-500')
                                @endif
                            </div>
                        </x-dropdown.item>
                        <x-dropdown.item :href="route('stories.index', 'sort=desc')">
                            <div class="flex items-center justify-between w-full">
                                <span>Sort by oldest first</span>
                                @if (request('sort', 'desc') === 'desc')
                                    @icon('check', 'h-6 w-6 md:h-5 md:w-5 shrink-0 text-primary-500')
                                @endif
                            </div>
                        </x-dropdown.item>
                    </x-dropdown.group>
                </x-dropdown>
            @endif

            @can('create', $storyClass)
                <x-button-filled tag="a" :href="route('stories.create')" data-cy="create" leading="add">
                    Add a story
                </x-button-filled>
            @endcan
        </x-slot:actions>
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
        @if ($selectedStory)
            <x-content-box height="sm" class="sticky top-0 z-30 bg-gray-50/50 dark:bg-gray-700/50 backdrop-blur border-y border-gray-200 dark:border-gray-200/10 sm:rounded-t-lg sm:border-t-0">
                <div class="flex md:hidden items-center justify-between">
                    <div class="text-xl sm:text-lg font-bold tracking-tight text-gray-900 dark:text-gray-100 flex-1 truncate">{{ $selectedStory->title }}</div>

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
                            <x-slot:trigger>
                                <x-icon.more class="h-7 w-7 md:h-6 md:w-6" />
                            </x-slot:trigger>

                            <x-dropdown.group>
                                @can('view', $selectedStory)
                                    <x-dropdown.item :href="route('stories.show', $selectedStory)" icon="show">
                                        <span>View</span>
                                    </x-dropdown.item>
                                @endcan

                                @can('update', $selectedStory)
                                    <x-dropdown.item :href="route('stories.edit', $selectedStory)" icon="edit">
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
                                    <x-dropdown.text class="uppercase tracking-wide font-semibold text-gray-500">
                                        Add a story
                                    </x-dropdown.text>
                                    <x-dropdown.item :href='route("stories.create", "direction=before&neighbor={$selectedStory->id}")' icon="move-up">
                                        <span>Before this story</span>
                                    </x-dropdown.item>
                                    <x-dropdown.item :href='route("stories.create", "direction=after&neighbor={$selectedStory->id}")' icon="move-down">
                                        <span>After this story</span>
                                    </x-dropdown.item>
                                    <x-dropdown.item :href='route("stories.create", "parent={$selectedStory->id}")' icon="move-right">
                                        <span>Inside this story</span>
                                    </x-dropdown.item>
                                </x-dropdown.group>
                            @endcan

                            @can('delete', $selectedStory)
                                <x-dropdown.group>
                                    <x-dropdown.item-danger :href="route('stories.delete', $selectedStory)" icon="delete">
                                        <span>Delete</span>
                                    </x-dropdown.item-danger>
                                </x-dropdown.group>
                            @endcan
                        </x-dropdown>
                    </div>
                </div>

                <div class="hidden md:flex items-center leading-0 space-x-8">
                    <span class="font-bold tracking-tight text-gray-900 dark:text-gray-100">{{ $selectedStory->title }}</span>

                    @can('view', $selectedStory)
                        <x-link :href="route('stories.show', $selectedStory)" size="none" color="primary" variant="text" leading="show">
                            View
                        </x-link>
                    @endcan

                    @can('update', $selectedStory)
                        <x-link :href="route('stories.edit', $selectedStory)" size="none" color="gray-text" leading="edit">
                            Edit
                        </x-link>
                    @endcan

                    @can('view', $selectedStory)
                        <x-link href="#" size="none" color="gray-text" leading="list">
                            Posts
                        </x-link>
                    @endcan

                    @can('delete', $selectedStory)
                        <x-link :href="route('stories.delete', $selectedStory)" size="none" color="gray-danger-text" leading="delete">
                            Delete
                        </x-link>
                    @endcan

                    @can('create', $selectedStory)
                        <x-dropdown>
                            <x-slot:trigger leading="add" color="gray-text">
                                <div class="flex items-center">
                                    <span>Add story</span>
                                    <x-icon.chevron-down class="h-4 w-4 shrink-0 ml-1.5" />
                                </div>
                            </x-slot:trigger>

                            <x-dropdown.group>
                                <x-dropdown.item :href='route("stories.create", "direction=before&neighbor={$selectedStory->id}")' icon="move-up">
                                    <span>Before this story</span>
                                </x-dropdown.item>
                                <x-dropdown.item :href='route("stories.create", "direction=after&neighbor={$selectedStory->id}")' icon="move-down">
                                    <span>After this story</span>
                                </x-dropdown.item>
                                <x-dropdown.item :href='route("stories.create", "parent={$selectedStory->id}")' icon="move-right">
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
                <x-stories.timeline :stories="$this->stories" :selected-story="$selectedStory" />
            </div>
        </x-content-box>
    @endif
</x-panel>
