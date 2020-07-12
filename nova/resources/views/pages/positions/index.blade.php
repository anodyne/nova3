@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$department->name">
        <x-slot name="pretitle">
            <a href="{{ route('departments.index') }}">Departments</a>
        </x-slot>

        <x-slot name="controls">
            @if ($positionCount > 0)
                @can('update', $positions->first())
                    <a href="{{ route('positions.index', [$department, 'reorder']) }}" class="flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150 mx-4">
                        @icon('arrow-sort', 'h-6 w-6')
                    </a>
                @endcan

                @can('create', 'Nova\Departments\Models\Position')
                    <a href="{{ route('positions.create', "department={$department->id}") }}" class="button button-primary" data-cy="create">
                        Add Position
                    </a>
                @endcan
            @endif
        </x-slot>
    </x-page-header>

    @if ($positionCount === 0)
        <x-empty-state
            image="organizer"
            message="Departments allow you to organize character positions into logical groups that you can display on your manifests."
            label="Add a deparment now"
            :link="route('positions.create')"
        ></x-empty-state>
    @else
        <x-panel x-data="sortableList()" x-init="initSortable()">
            <div>
                <div class="p-4 | sm:hidden">
                    <select x-on:change="window.location = $event.target.value" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 transition ease-in-out duration-150">
                        <option value="{{ route('departments.edit', $department) }}">Department Info</option>
                        <option value="email">Positions</option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <div class="border-b border-gray-200 px-4 | sm:px-6">
                        <nav class="-mb-px flex">
                            <a href="{{ route('departments.edit', $department) }}" class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none">
                                Department Info
                            </a>
                            <a href="{{ route('positions.index', $department) }}" class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 border-blue-500 text-blue-600 focus:outline-none">
                                Positions
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
            @if ($isReordering)
                <div class="bg-info-100 border-t border-b border-info-200 p-4 | sm:border-t-0">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            @icon('arrow-sort', 'h-6 w-6 text-info-600')
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm leading-5 font-medium text-info-900">
                                Change Sorting Order
                            </h3>
                            <div class="mt-2 text-sm leading-5 text-info-800">
                                <p>Positions appear in the order you set throughout Nova. To change the sorting of the positions, drag them to the desired order and then click Save Sort Order below.</p>
                            </div>
                            <div class="mt-4">
                                <x-form :action="route('positions.reorder', $department)" id="form-reorder">
                                    <input type="hidden" name="sort" x-model="newSortOrder">
                                    <div class="flex items-center space-x-4">
                                        <button type="submit" form="form-reorder" class="button button-info">Save Sort Order</button>
                                        <a href="{{ route('positions.index', $department) }}" class="text-info-600 text-sm font-medium transition ease-in-out duration-150 hover:text-info-800">
                                            Cancel
                                        </a>
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
                <li class="sortable-item border-t border-gray-200 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out @if ($isReordering) first:border-0 last:rounded-b-md @endif" data-id="{{ $position->id }}">
                    <div class="block">
                        <div class="flex items-center px-4 py-4 | sm:px-6">
                            @if ($isReordering)
                                <div class="sortable-handle flex-shrink-0 cursor-move mr-5">
                                    @icon('reorder', 'h-5 w-5 text-gray-400')
                                </div>
                            @endif
                            <div class="min-w-0 flex-1 px-4 | md:grid md:grid-cols-2 md:gap-4">
                                <div>
                                    <div class="leading-normal font-medium truncate">
                                        {{ $position->name }}
                                    </div>
                                    <div class="mt-2 flex items-center">
                                        <div>
                                            @if ($position->active)
                                                <x-badge size="sm" type="success">Active</x-badge>
                                            @else
                                                <x-badge size="sm">Inactive</x-badge>
                                            @endif
                                        </div>
                                        @if ($position->active)
                                            <div class="hidden items-center text-sm leading-5 text-gray-500 ml-6 | sm:flex">
                                                {{ $position->available }} available @choice('slot|slots', $position->available)
                                            </div>
                                        @endif

                                        <div class="hidden items-center text-sm leading-5 text-gray-500 ml-6 | sm:flex">
                                            {{ $position->active_characters_count }} assigned @choice('character|characters', $position->active_characters_count)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="leading-0">
                                <x-dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500">
                                    @icon('more', 'h-6 w-6')

                                    <x-slot name="dropdown">
                                        @can('view', $position)
                                            <a href="{{ route('positions.show', $position) }}" class="{{ $component->link() }}" data-cy="view">
                                                @icon('show', $component->icon())
                                                <span>View</span>
                                            </a>
                                        @endcan

                                        @can('update', $position)
                                            <a href="{{ route('positions.edit', $position) }}" class="{{ $component->link() }}" data-cy="edit">
                                                @icon('edit', $component->icon())
                                                <span>Edit</span>
                                            </a>
                                        @endcan

                                        @can('delete', $position)
                                            <div class="{{ $component->divider() }}"></div>
                                            <button
                                                x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($position) }});"
                                                class="{{ $component->link() }}"
                                                data-cy="delete"
                                            >
                                                @icon('delete', $component->icon())
                                                <span>Delete</span>
                                            </button>
                                        @endcan
                                    </x-slot>
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
                <div class="px-4 py-2 border-t border-gray-200 | sm:px-6 sm:py-3">
                    {{ $positions->withQueryString()->links() }}
                </div>
            @endif
        </x-panel>

        <x-tips section="positions" />

        <x-modal color="red" title="Delete Position?" icon="warning" :url="route('positions.delete')">
            <x-slot name="footer">
                <span class="flex w-full | sm:col-start-2">
                    <button form="form" class="button button-danger w-full">
                        Delete
                    </button>
                </span>
                <span class="mt-3 flex w-full | sm:mt-0 sm:col-start-1">
                    <button x-on:click="$dispatch('modal-close')" type="button" class="button w-full">
                        Cancel
                    </button>
                </span>
            </x-slot>
        </x-modal>
    @endif
@endsection

@push('scripts')
    <script>
        function sortableList() {
            return {
                newSortOrder: '',
                sortable: null,

                initSortable () {
                    const el = document.getElementById('sortable-list');

                    this.sortable = Sortable.create(el, {
                        draggable: '.sortable-item',
                        handle: '.sortable-handle',
                        onEnd: () => {
                            this.newSortOrder = this.sortable.toArray();
                        }
                    });
                }
            };
        }
    </script>
@endpush
