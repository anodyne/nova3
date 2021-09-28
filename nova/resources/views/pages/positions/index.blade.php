@extends($meta->template)

@section('content')
    <x-page-header :title="$department->name">
        <x-slot name="pretitle">
            <a href="{{ route('departments.index') }}">Departments</a>
        </x-slot>

        <x-slot name="controls">
            @if ($positionCount > 0)
                @can('update', $positions->first())
                    <x-link :href="route('positions.index', [$department, 'reorder'])" color="gray-text" size="none">
                        @icon('arrow-sort', 'h-6 w-6')
                    </x-link>
                @endcan

                @can('create', 'Nova\Departments\Models\Position')
                    <x-link :href='route("positions.create", "department={$department->id}")' color="blue" data-cy="create">
                        Add Position
                    </x-link>
                @endcan
            @endif
        </x-slot>
    </x-page-header>

    @if ($positionCount === 0)
        <x-empty-state
            image="organizer"
            message="Positions are the jobs or stations that characters can be assigned to for display on your manifests."
            label="Add a position now"
            :link="route('positions.create')"
        ></x-empty-state>
    @else
        <x-panel x-data="sortableList" on-edge>
            <div>
                <div class="p-4 sm:hidden">
                    <select @change="window.location = $event.target.value" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base border-gray-6 focus:outline-none focus:ring focus:border-blue-7 transition ease-in-out duration-150 sm:text-sm">
                        <option value="{{ route('departments.edit', $department) }}">Department Info</option>
                        <option value="email">Positions</option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <div class="border-b border-gray-6 px-4 sm:px-6">
                        <nav class="-mb-px flex">
                            <a href="{{ route('departments.edit', $department) }}" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-9 hover:text-gray-11 hover:border-gray-6 focus:outline-none">
                                Department Info
                            </a>
                            <a href="{{ route('positions.index', $department) }}" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm border-blue-7 text-blue-11 focus:outline-none">
                                Positions
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
            @if ($isReordering)
                <div class="bg-purple-3 border-t border-b border-purple-6 p-4 sm:border-t-0">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            @icon('arrow-sort', 'h-6 w-6 text-purple-9')
                        </div>
                        <div class="ml-3">
                            <h3 class="font-medium text-purple-11">
                                Change Sorting Order
                            </h3>
                            <div class="mt-2 text-sm text-purple-11">
                                <p>Positions appear in the order you set throughout Nova. To change the sorting of the positions, drag them to the desired order and then click Save Sort Order below.</p>
                            </div>
                            <div class="mt-4">
                                <x-form :action="route('positions.reorder', $department)" id="form-reorder" :divide="false">
                                    <input type="hidden" name="sort" x-model="newSortOrder">
                                    <div class="flex items-center space-x-4">
                                        <x-button type="submit" form="form-reorder" color="purple">Save Sort Order</x-button>
                                        <x-link :href="route('positions.index', $department)" color="purple-text" size="none">
                                            Cancel
                                        </x-link>
                                    </div>
                                </x-form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="px-4 py-2 | sm:px-6 sm:py-3">
                    <x-search-filter placeholder="Find a position..." :search="$search" />
                </div>
            @endif

            <ul id="sortable-list">
            @forelse ($positions as $position)
                <li class="sortable-item border-t border-gray-6 hover:bg-gray-2 focus:outline-none focus:bg-gray-2 transition duration-150 ease-in-out @if ($isReordering) first:border-0 last:rounded-b-md @endif" data-id="{{ $position->id }}">
                    <div class="block">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            @if ($isReordering)
                                <div class="sortable-handle flex-shrink-0 cursor-move mr-5">
                                    @icon('reorder', 'h-5 w-5 text-gray-9')
                                </div>
                            @endif
                            <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                <div>
                                    <div class="font-medium truncate">
                                        {{ $position->name }}
                                    </div>
                                    <div class="mt-2 flex items-center">
                                        <div>
                                            @if ($position->active)
                                                <x-badge size="xs" color="green">Active</x-badge>
                                            @else
                                                <x-badge size="xs" color="gray">Inactive</x-badge>
                                            @endif
                                        </div>
                                        @if ($position->active)
                                            <div class="hidden items-center text-sm text-gray-11 ml-6 | sm:flex">
                                                {{ $position->available }} available @choice('slot|slots', $position->available)
                                            </div>
                                        @endif

                                        <div class="hidden items-center text-sm text-gray-11 ml-6 | sm:flex">
                                            {{ $position->active_characters_count }} assigned @choice('character|characters', $position->active_characters_count)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="leading-0">
                                <x-dropdown placement="bottom-end">
                                    <x-slot name="trigger">@icon('more', 'h-6 w-6')</x-slot>

                                    <x-dropdown.group>
                                        @can('view', $position)
                                            <x-dropdown.item :href="route('positions.show', $position)" icon="show" data-cy="view">
                                                <span>View</span>
                                            </x-dropdown.item>
                                        @endcan

                                        @can('update', $position)
                                            <x-dropdown.item :href="route('positions.edit', $position)" icon="edit" data-cy="edit">
                                                <span>Edit</span>
                                            </x-dropdown.item>
                                        @endcan

                                        @can('duplicate', $position)
                                            <x-dropdown.item type="button" icon="duplicate" @click="$dispatch('dropdown-toggle');$dispatch('modal-duplicate', {{ json_encode($position) }});" data-cy="duplicate">
                                                <span>Duplicate</span>
                                            </x-dropdown.item>
                                        @endcan
                                    </x-dropdown.group>

                                    @can('delete', $position)
                                        <x-dropdown.group>
                                            <x-dropdown.item-danger type="button" icon="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($position) }});" data-cy="delete">
                                                <span>Delete</span>
                                            </x-dropdown.item-danger>
                                        </x-dropdown.group>
                                    @endcan
                                </x-dropdown>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <x-search-not-found>
                    No positions found
                </x-search-not-found>
            @endforelse
            </ul>

            @if (! $isReordering)
                <div class="px-4 py-2 border-t border-gray-6 | sm:px-6 sm:py-3">
                    {{ $positions->withQueryString()->links() }}
                </div>
            @endif
        </x-panel>

        <x-tips section="positions" />

        <x-modal color="red" title="Delete Position?" icon="warning" :url="route('positions.delete')">
            <x-slot name="footer">
                <span class="flex w-full | sm:col-start-2">
                    <x-button type="submit" form="form" color="red" full-width>
                        Delete
                    </x-button>
                </span>
                <span class="mt-3 flex w-full | sm:mt-0 sm:col-start-1">
                    <x-button @click="$dispatch('modal-close')" type="button" color="white" full-width>
                        Cancel
                    </x-button>
                </span>
            </x-slot>
        </x-modal>

        <x-modal color="blue" title="Duplicate position" icon="duplicate" :url="route('positions.confirm-duplicate')" event="modal-duplicate" :wide="true">
            <x-slot name="footer">
                <span class="flex w-full | sm:col-start-2">
                    <x-button type="submit" form="form-duplicate" color="blue" full-width>
                        Duplicate
                    </x-button>
                </span>
                <span class="mt-3 flex w-full | sm:mt-0 sm:col-start-1">
                    <x-button @click="$dispatch('modal-close')" type="button" color="white" full-width>
                        Cancel
                    </x-button>
                </span>
            </x-slot>
        </x-modal>
    @endif
@endsection
