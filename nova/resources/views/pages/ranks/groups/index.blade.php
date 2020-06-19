@extends($__novaTemplate)

@section('content')
    <x-page-header title="Rank Groups">
        <x-slot name="pretitle">
            <a href="{{ route('ranks.index') }}">
                Ranks
            </a>
        </x-slot>

        <x-slot name="controls">
            @can('create', 'Nova\Ranks\Models\RankGroup')
                <a href="{{ route('ranks.groups.create') }}" class="button button-primary" data-cy="create">
                    Add Rank Group
                </a>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
        <div class="px-4 py-2 | sm:px-6 sm:py-3">
            <x-search-filter placeholder="Find a rank group..." :search="$search" />
        </div>

        <ul>
        @forelse ($groups as $group)
            <li class="border-t border-gray-200">
                <div class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                    <div class="px-4 py-4 flex items-center | sm:px-6">
                        <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <div class="leading-normal font-medium truncate">
                                    {{ $group->name }}
                                </div>
                                <div class="mt-2 flex">
                                    <div class="flex items-center text-sm leading-5 text-gray-500">
                                        @icon('users', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                                        <span>
                                            18 @choice('rank|ranks', 18)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ml-5 flex-shrink-0">
                            <x-dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500">
                                @icon('more', 'h-6 w-6')

                                <x-slot name="dropdown">
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
                                        <button type="submit" class="{{ $component->link() }}" form="duplicate-{{ $group->id }}" data-cy="duplicate">
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
                                </x-slot>
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

        <div class="px-4 py-2 border-t border-gray-200 | sm:px-6 sm:py-3">
            {{ $groups->withQueryString()->links() }}
        </div>
    </x-panel>

    <x-modal color="red" headline="Delete rank group?" icon="warning" :url="route('ranks.groups.delete')">
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
@endsection
