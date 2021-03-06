@extends($__novaTemplate)

@section('content')
    <x-page-header title="Rank Groups">
        <x-slot name="pretitle">
            <a href="{{ route('ranks.index') }}">
                Ranks
            </a>
        </x-slot>

        <x-slot name="controls">
            @if ($groupCount > 0)
                @can('update', $groups->first())
                    <x-button-link :href="route('ranks.groups.index', 'reorder')" color="gray-text" size="none">
                        @icon('arrow-sort', 'h-6 w-6')
                    </x-button-link>
                @endcan

                @can('create', 'Nova\Ranks\Models\RankGroup')
                    <x-button-link :href="route('ranks.groups.create')" color="blue" data-cy="create">
                        Add Rank Group
                    </x-button-link>
                @endcan
            @endif
        </x-slot>
    </x-page-header>

    @if ($groupCount === 0)
        <x-empty-state
            image="organizer"
            message="Rank groups are a simple way to collect related rank items together for simpler searching and selecting ranks in Nova."
            label="Add a rank group now"
            :link="route('ranks.groups.create')"
        ></x-empty-state>
    @else
        <x-panel x-data="AlpineComponents.sortableList()" x-init="init()">
            @if ($isReordering)
                <div class="bg-purple-100 border-t border-b border-purple-200 p-4 | sm:rounded-t-md sm:border-t-0">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            @icon('arrow-sort', 'h-6 w-6 text-purple-600')
                        </div>
                        <div class="ml-3">
                            <h3 class="font-medium text-purple-900">
                                Change Sorting Order
                            </h3>
                            <div class="mt-2 text-sm text-purple-800">
                                <p>Rank groups appear in the order you set throughout Nova. To change the sorting of the rank groups, drag them to the desired order and then click Save Sort Order below.</p>
                            </div>
                            <div class="mt-4">
                                <x-form :action="route('ranks.groups.reorder')" id="form-reorder" :divide="false">
                                    <input type="hidden" name="sort" x-model="newSortOrder">
                                    <div class="flex items-center space-x-4">
                                        <x-button type="submit" form="form-reorder" color="purple">Save Sort Order</x-button>
                                        <x-button-link :href="route('ranks.groups.index')" color="purple-text" size="none">
                                            Cancel
                                        </x-button-link>
                                    </div>
                                </x-form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="px-4 py-2 | sm:px-6 sm:py-3">
                    <x-search-filter placeholder="Find a rank group..." :search="$search" />
                </div>
            @endif

            <ul id="sortable-list">
            @forelse ($groups as $group)
                <li class="sortable-item border-t border-gray-200 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out @if ($isReordering) first:border-0 last:rounded-b-md @endif" data-id="{{ $group->id }}">
                    <div class="block">
                        <div class="px-4 py-4 flex items-center | sm:px-6">
                            @if ($isReordering)
                                <div class="sortable-handle flex-shrink-0 cursor-move mr-5">
                                    @icon('reorder', 'h-5 w-5 text-gray-400')
                                </div>
                            @endif
                            <div class="min-w-0 flex-1 | sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <div class="font-medium truncate">
                                        {{ $group->name }}
                                    </div>
                                    <div class="mt-2 flex">
                                        <div class="flex items-center text-sm text-gray-500">
                                            @icon('star', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                                            <span>
                                                {{ $group->ranks_count }} @choice('rank item|rank items', $group->ranks_count)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ml-5 flex-shrink-0 leading-0">
                                <x-dropdown placement="bottom-end">
                                    <x-slot name="trigger">@icon('more', 'h-6 w-6')</x-slot>

                                    @can('view', $group)
                                        <a href="{{ route('ranks.groups.show', $group) }}" class="{{ $component->link() }}" data-cy="view">
                                            @icon('show', $component->icon())
                                            <span>View</span>
                                        </a>
                                    @endcan

                                    @can('update', $group)
                                        <a href="{{ route('ranks.groups.edit', $group) }}" class="{{ $component->link() }}" data-cy="edit">
                                            @icon('edit', $component->icon())
                                            <span>Edit</span>
                                        </a>
                                    @endcan

                                    @can('duplicate', $group)
                                        <button
                                            x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-duplicate', {{ json_encode($group) }});"
                                            class="{{ $component->link() }}"
                                            data-cy="duplicate"
                                        >
                                            @icon('duplicate', $component->icon())
                                            <span>Duplicate</span>
                                        </button>
                                        <x-form :action="route('ranks.groups.duplicate', $group)" id="duplicate-{{ $group->id }}" class="hidden" />
                                    @endcan

                                    @can('delete', $group)
                                        <div class="{{ $component->divider() }}"></div>
                                        <button
                                            x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($group) }});"
                                            class="{{ $component->link() }}"
                                            data-cy="delete"
                                        >
                                            @icon('delete', $component->icon())
                                            <span>Delete</span>
                                        </button>
                                    @endcan
                                </x-dropdown>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <x-search-not-found>
                    No rank groups found
                </x-search-not-found>
            @endforelse
            </ul>

            @if (! $isReordering)
                <div class="px-4 py-2 border-t border-gray-200 | sm:px-6 sm:py-3">
                    {{ $groups->withQueryString()->links() }}
                </div>
            @endif
        </x-panel>

        <x-tips section="ranks" />

        <x-modal color="red" title="Delete rank group?" icon="warning" :url="route('ranks.groups.delete')">
            <x-slot name="footer">
                <span class="flex w-full | sm:col-start-2">
                    <x-button type="submit" type="submit" form="form" color="red" full-width>
                        Delete
                    </x-button>
                </span>
                <span class="mt-3 flex w-full | sm:mt-0 sm:col-start-1">
                    <x-button x-on:click="$dispatch('modal-close')" type="button" color="white" full-width>
                        Cancel
                    </x-button>
                </span>
            </x-slot>
        </x-modal>

        <x-modal color="blue" title="Duplicate rank group" icon="duplicate" :url="route('ranks.groups.confirm-duplicate')" event="modal-duplicate" :wide="true">
            <x-slot name="footer">
                <span class="flex w-full | sm:col-start-2">
                    <x-button type="submit" form="form-duplicate" color="blue" full-width>
                        Duplicate
                    </x-button>
                </span>
                <span class="mt-3 flex w-full | sm:mt-0 sm:col-start-1">
                    <x-button x-on:click="$dispatch('modal-close')" type="button" color="white" full-width>
                        Cancel
                    </x-button>
                </span>
            </x-slot>
        </x-modal>
    @endif
@endsection
