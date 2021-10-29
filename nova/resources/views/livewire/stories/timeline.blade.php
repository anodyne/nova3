<x-panel>
    @if ($selectedStory)
        <x-content-box height="xs" class="sticky top-0 z-30 bg-gray-2 backdrop-filter backdrop-blur bg-opacity-50 border-t border-b border-gray-6 sm:rounded-t-lg sm:border-t-0">
            <div class="flex md:hidden items-center justify-between">
                <div class="font-bold tracking-tight text-gray-12 flex-1 truncate">{{ $selectedStory->title }}</div>

                <div class="flex items-center space-x-4">
                    @can('update', $selectedStory)
                        <span>
                            @livewire('stories:status', ['story' => $selectedStory], key("status-{{ $selectedStory->id }}"))
                        </span>
                    @endcan

                    <x-dropdown placement="bottom-end" wide>
                        <x-slot name="trigger">
                            <x-icon.more class="h-6 w-6" />
                        </x-slot>

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

                        <x-dropdown.group>
                            <x-dropdown.item icon="list">
                                <span>Posts</span>
                            </x-dropdown.item>
                        </x-dropdown.group>

                        @can('create', $selectedStory)
                            <x-dropdown.group>
                                <x-dropdown.text class="uppercase tracking-wide font-semibold text-gray-9">
                                    Add a story
                                </x-dropdown.text>
                                <x-dropdown.item :href='route("stories.create", "direction=before&neighbor={$selectedStory->id}")' icon="move-up">
                                    <span>Before {{ $selectedStory->title }}</span>
                                </x-dropdown.item>
                                <x-dropdown.item :href='route("stories.create", "direction=after&neighbor={$selectedStory->id}")' icon="move-down">
                                    <span>After {{ $selectedStory->title }}</span>
                                </x-dropdown.item>
                                <x-dropdown.item :href='route("stories.create", "parent={$selectedStory->id}")' icon="move-right">
                                    <span>Inside {{ $selectedStory->title }}</span>
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
                <span class="font-bold tracking-tight text-gray-12">{{ $selectedStory->title }}</span>

                @can('view', $selectedStory)
                    <x-link :href="route('stories.show', $selectedStory)" size="none" color="gray-text">
                        @icon('show', 'h-5 w-5')
                        <span>View</span>
                    </x-link>
                @endcan

                @can('update', $selectedStory)
                    <x-link :href="route('stories.edit', $selectedStory)" size="none" color="gray-text">
                        @icon('edit', 'h-5 w-5')
                        <span>Edit</span>
                    </x-link>
                @endcan

                @can('view', $selectedStory)
                    <x-link href="#" size="none" color="gray-text">
                        @icon('list', 'h-5 w-5')
                        <span>Posts</span>
                    </x-link>
                @endcan

                @can('delete', $selectedStory)
                    <x-link :href="route('stories.delete', $selectedStory)" size="none" color="gray-red-text">
                        @icon('delete', 'h-5 w-5')
                        <span>Delete</span>
                    </x-link>
                @endcan

                @can('create', $selectedStory)
                    <x-dropdown wide>
                        <x-slot name="trigger">
                            @icon('add', 'h-5 w-5 flex-shrink-0')
                            <span>Add story</span>
                            <x-icon.chevron-down class="h-4 w-4 flex-shrink-0" />
                        </x-slot>

                        <x-dropdown.group>
                            <x-dropdown.item :href='route("stories.create", "direction=before&neighbor={$selectedStory->id}")' icon="move-up">
                                <span>Before {{ $selectedStory->title }}</span>
                            </x-dropdown.item>
                            <x-dropdown.item :href='route("stories.create", "direction=after&neighbor={$selectedStory->id}")' icon="move-down">
                                <span>After {{ $selectedStory->title }}</span>
                            </x-dropdown.item>
                            <x-dropdown.item :href='route("stories.create", "parent={$selectedStory->id}")' icon="move-right">
                                <span>Inside {{ $selectedStory->title }}</span>
                            </x-dropdown.item>
                        </x-dropdown.group>
                    </x-dropdown>
                @endcan

                @can('update', $selectedStory)
                    <span>
                        @livewire('stories:status', ['story' => $selectedStory], key("status-{{ $selectedStory->id }}"))
                    </span>
                @endcan
            </div>
        </x-content-box>
    @endif

    <x-content-box height="xs" width="xs">
        <div class="w-full">
            <x-stories.timeline :stories="$this->stories" />
        </div>
    </x-content-box>
</x-panel>