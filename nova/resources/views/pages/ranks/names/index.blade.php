@extends($__novaTemplate)

@section('content')
    <x-page-header title="Rank Names">
        <x-slot name="pretitle">
            <a href="{{ route('ranks.index') }}">
                Ranks
            </a>
        </x-slot>

        <x-slot name="controls">
            @if ($nameCount > 0)
                @can('update', $names->first())
                    <x-button-link :href="route('ranks.names.index', 'reorder')" color="gray-text" size="none" class="mx-4">
                        @icon('arrow-sort', 'h-6 w-6')
                    </x-button-link>
                @endcan

                @can('create', 'Nova\Ranks\Models\RankName')
                    <x-button-link :href="route('ranks.names.create')" color="blue" data-cy="create">
                        Add Rank Name
                    </x-button-link>
                @endcan
            @endif
        </x-slot>
    </x-page-header>

    @if ($nameCount === 0)
        <x-empty-state
            image="diary"
            message="Rank names eliminate the repetitive task of setting the name of a rank by letting you re-use names across all of your rank items."
            label="Add a rank name now"
            :link="route('ranks.names.create')"
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
                            <h3 class="text-sm font-medium text-purple-900">
                                Change Sorting Order
                            </h3>
                            <div class="mt-2 text-sm text-purple-800">
                                <p>Rank names appear in the order you set throughout Nova. To change the sorting of the rank names, drag them to the desired order and then click Save Sort Order below.</p>
                            </div>
                            <div class="mt-4">
                                <x-form :action="route('ranks.names.reorder')" id="form-reorder" :divide="false">
                                    <input type="hidden" name="sort" x-model="newSortOrder">
                                    <div class="flex items-center space-x-4">
                                        <x-button type="submit" form="form-reorder" color="purple">Save Sort Order</x-button>
                                        <x-button-link :href="route('ranks.names.index')" color="purple-text" size="none">
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
                    <x-search-filter placeholder="Find a rank name..." :search="$search" />
                </div>
            @endif

            <ul id="sortable-list">
            @forelse ($names as $name)
                <li class="sortable-item border-t border-gray-200 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out @if ($isReordering) first:border-0 last:rounded-b-md @endif" data-id="{{ $name->id }}">
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
                                        {{ $name->name }}
                                    </div>
                                    <div class="mt-2 flex">
                                        <div class="flex items-center text-sm text-gray-500">
                                            @icon('star', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                                            <span>
                                                {{ $name->ranks_count }} @choice('rank item|rank items', $name->ranks_count)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ml-5 flex-shrink-0 leading-0">
                                <x-dropdown placement="bottom-end">
                                    <x-slot name="trigger">@icon('more', 'h-6 w-6')</x-slot>

                                    @can('view', $name)
                                        <a href="{{ route('ranks.names.show', $name) }}" class="{{ $component->link() }}" data-cy="view">
                                            @icon('show', $component->icon())
                                            <span>View</span>
                                        </a>
                                    @endcan

                                    @can('update', $name)
                                        <a href="{{ route('ranks.names.edit', $name) }}" class="{{ $component->link() }}" data-cy="edit">
                                            @icon('edit', $component->icon())
                                            <span>Edit</span>
                                        </a>
                                    @endcan

                                    @can('duplicate', $name)
                                        <button type="submit" class="{{ $component->link() }}" form="duplicate-{{ $name->id }}" data-cy="duplicate">
                                            @icon('duplicate', $component->icon())
                                            <span>Duplicate</span>
                                        </button>
                                        <x-form :action="route('ranks.names.duplicate', $name)" id="duplicate-{{ $name->id }}" class="hidden" />
                                    @endcan

                                    @can('delete', $name)
                                        <div class="{{ $component->divider() }}"></div>
                                        <button
                                            x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($name) }});"
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
                    No rank names found
                </x-search-not-found>
            @endforelse
            </ul>

            @if (! $isReordering)
                <div class="px-4 py-2 border-t border-gray-200 | sm:px-6 sm:py-3">
                    {{ $names->withQueryString()->links() }}
                </div>
            @endif
        </x-panel>

        <x-tips section="ranks" />

        <x-modal color="red" title="Delete rank name?" icon="warning" :url="route('ranks.names.delete')">
            <x-slot name="footer">
                <span class="flex w-full | sm:col-start-2">
                    <x-button form="form" color="red" full-width>
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
    @endif
@endsection
