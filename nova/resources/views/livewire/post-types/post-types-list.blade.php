<x-panel class="{{ $reordering ? 'overflow-hidden' : '' }}" x-data="filtersPanel()">
    <x-panel.header title="Post types" message="Control the content users post into stories.">
        @if (! $reordering)
            <x-slot:controls>
                @can('update', $postTypes->first())
                    <x-button
                        size="none"
                        color="gray-text"
                        wire:click="startReordering"
                        leading="arrow-sort"
                    >
                        Reorder
                    </x-button>
                @endcan

                @can('create', $postTypeClass)
                    <x-link
                        :href="route('post-types.create')"
                        color="primary"
                        data-cy="create"
                        class="order-first md:order-last"
                        leading="add"
                    >
                        Add a post type
                    </x-link>
                @endcan
            </x-slot:controls>
        @else
            <x-slot:message>
                <x-panel.info icon="arrow-sort" title="Change sorting order" class="mt-4">
                    <div class="space-y-4">
                        <p>Post types will appear in the order below whenever they're shown throughout Nova. To change the sorting of post types, drag them to the desired order. Click Finish to return to the management view.</p>

                        <div>
                            <x-button wire:click="stopReordering" color="info">Finish</x-button>
                        </div>
                    </div>
                </x-panel.info>
            </x-slot:message>
        @endif
    </x-panel.header>

    @if (! $reordering)
        @if ($postTypeCount === 0)
            <x-empty-state.large
                icon="list"
                title="Start by creating a post type"
                message="Post types allow you to control the type of content users can create inside of stories."
                label="Add a post type"
                :link="route('post-types.create')"
                :link-access="gate()->allows('create', $postTypeClass)"
            ></x-empty-state.large>
        @else
            <x-content-box height="sm" class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6">
                <div class="flex-1">
                    <x-input.group>
                        <x-input.text placeholder="Find post types(s) by name" wire:model="search">
                            <x-slot:leadingAddOn>
                                @icon('search', 'h-5 w-5')
                            </x-slot:leadingAddOn>

                            @if ($search)
                                <x-slot:trailingAddOn>
                                    <x-button size="none" color="light-gray-text" wire:click="$set('search', '')">
                                        @icon('close', 'h-5 w-5')
                                    </x-button>
                                </x-slot:trailingAddOn>
                            @endif
                        </x-input.text>
                    </x-input.group>
                </div>

                <div class="shrink flex justify-between md:justify-start items-center space-x-4">
                    <x-button
                        size="none"
                        :color="$isFiltered ? 'primary-text' : 'gray-text'"
                        x-bind="trigger"
                        leading="filter"
                    >
                        <span>Filters</span>
                        @if ($activeFilterCount > 0)
                            <x-badge color="primary" size="sm" class="ml-2">{{ $activeFilterCount }}</x-badge>
                        @endif
                    </x-button>
                </div>
            </x-content-box>

            <x-panel.filters x-bind="panel" x-cloak>
                <livewire:livewire-filters-checkbox :filter="$filters['status']" />
                <livewire:livewire-filters-radio :filter="$filters['requires_access_role']" />
            </x-panel.filters>
        @endif
    @endif

    <x-table-list columns="3" wire:sortable="reorder">
        @if ($postTypeCount > 0)
            @if ($postTypes->count() > 0 && ! $reordering)
                <x-slot:header>
                    <div>Name</div>
                    <div>Required Access Role</div>
                    <div>Status</div>
                </x-slot:header>
            @endif

            @forelse ($postTypes as $postType)
                <x-table-list.row wire:sortable.item="{{ $postType->id }}" wire:key="post-type-{{ $postType->id }}">
                    <div class="flex items-center">
                        @if ($reordering)
                            <div class="shrink-0 cursor-move mr-2 md:mr-4" wire:sortable.handle>
                                <x-icon.move-handle class="h-6 w-6 md:h-5 md:w-5 text-gray-400 dark:text-gray-500" />
                            </div>
                        @endif

                        <div class="flex items-center space-x-3">
                            <div class="shrink-0 mt-0.5" style="color:{{ $postType->color }}">
                                @isset($postType->icon)
                                    @icon($postType->icon, 'h-6 w-6')
                                @else
                                    <div class="h-6 w-6"></div>
                                @endisset
                            </div>

                            <x-table-list.primary-column>
                                {{ $postType->name }}
                            </x-table-list.primary-column>
                        </div>
                    </div>

                    <div @class([
                        'flex items-center',
                        'ml-8 md:ml-0' => $reordering
                    ])>
                        @if ($postType->role)
                            <x-badge color="gray">{{ $postType->role->display_name }}</x-badge>
                        @endif
                    </div>

                    <div @class([
                        'flex items-center',
                        'ml-8 md:ml-0' => $reordering
                    ])>
                        <x-badge :color="$postType->status->color()">
                            {{ $postType->status->displayName() }}
                        </x-badge>
                    </div>

                    @if (! $reordering)
                        <x-slot:controls>
                            <x-dropdown placement="bottom-end">
                                <x-slot:trigger>
                                    <x-icon.more class="h-6 w-6" />
                                </x-slot:trigger>

                                <x-dropdown.group>
                                    @can('view', $postType)
                                        <x-dropdown.item :href="route('post-types.show', $postType)" icon="show" data-cy="view">
                                            <span>View</span>
                                        </x-dropdown.item>
                                    @endcan

                                    @can('update', $postType)
                                        <x-dropdown.item :href="route('post-types.edit', $postType)" icon="edit" data-cy="edit">
                                            <span>Edit</span>
                                        </x-dropdown.item>
                                    @endcan

                                    @can('duplicate', $postType)
                                        <x-dropdown.item type="submit" icon="copy" form="duplicate-{{ $postType->id }}" data-cy="duplicate">
                                            <span>Duplicate</span>

                                            <x-slot:buttonForm>
                                                <x-form :action="route('post-types.duplicate', $postType)" id="duplicate-{{ $postType->id }}" class="hidden" />
                                            </x-slot:buttonForm>
                                        </x-dropdown.item>
                                    @endcan
                                </x-dropdown.group>

                                @can('delete', $postType)
                                    <x-dropdown.group>
                                        <x-dropdown.item-danger type="button" icon="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($postType) }});" data-cy="delete">
                                            <span>Delete</span>
                                        </x-dropdown.item-danger>
                                    </x-dropdown.group>
                                @endcan
                            </x-dropdown>
                        </x-slot:controls>
                    @endif
                </x-table-list.row>
            @empty
                <x-slot:emptyMessage>
                    <x-empty-state.not-found
                        entity="post type"
                        :search="$search"
                        :primary-access="gate()->allows('create', $postTypeClass)"
                    >
                        <x-slot:primary>
                            <x-link :href="route('post-types.create')" color="primary">
                                Add a post type
                            </x-link>
                        </x-slot:primary>

                        <x-slot:secondary>
                            <x-button wire:click="$set('search', '')">Clear search</x-button>
                        </x-slot:secondary>
                    </x-empty-state.not-found>
                </x-slot:emptyMessage>
            @endforelse

            @if (! $reordering && $postTypes->count() > 0)
                <x-slot:footer>
                    {{ $postTypes->withQueryString()->links() }}
                </x-slot:footer>
            @endif
        @endif
    </x-table-list>
</x-panel>
