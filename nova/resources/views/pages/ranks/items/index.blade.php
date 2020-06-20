@extends($__novaTemplate)

@section('content')
    <x-page-header title="Rank Items">
        <x-slot name="pretitle">
            <a href="{{ route('ranks.index') }}">
                Ranks
            </a>
        </x-slot>

        <x-slot name="controls">
            <x-dropdown placement="bottom-end" class="flex items-center text-gray-400 dark:text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150 mx-4 {{ request()->has('group') ? 'text-blue-500' : '' }}">
                @icon('filter', 'h-6 w-6')

                <x-slot name="dropdown">
                    <div class="{{ $component->text() }} uppercase tracking-wide font-semibold text-gray-500">
                        Filter rank items
                    </div>
                    <a href="{{ route('ranks.items.index') }}" class="{{ $component->link() }}">All rank groups</a>
                    @foreach ($groups as $group)
                        <a href="{{ route('ranks.items.index', 'group=' . strtolower($group->name)) }}" class="{{ $component->link() }}">{{ $group->name }}</a>
                    @endforeach
                </x-slot>
            </x-dropdown>

            @can('create', 'Nova\Ranks\Models\RankItem')
                <a href="{{ route('ranks.items.create') }}" class="button button-primary" data-cy="create">
                    Add Rank Item
                </a>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
        <div class="px-4 py-2 | sm:px-6 sm:py-3">
            <x-search-filter placeholder="Find a rank..." :search="$search" />
        </div>

        <ul>
        @forelse ($items as $item)
            <li class="border-t border-gray-200">
                <div class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                    <div class="px-4 py-4 flex items-center | sm:px-6">
                        <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                            <div class="flex items-center">
                                <x-rank :base="$item->base_image" :overlay="$item->overlay_image" />
                                <div class="ml-3 font-medium">
                                    {{ $item->rank_name }}
                                </div>
                            </div>
                        </div>
                        <div class="ml-5 flex-shrink-0">
                            <x-dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500">
                                @icon('more', 'h-6 w-6')

                                <x-slot name="dropdown">
                                    @can('view', $item)
                                        <a href="{{ route('ranks.items.show', $item) }}" class="{{ $component->link() }}" data-cy="view">
                                            @icon('show', $component->icon())
                                            <span>View</span>
                                        </a>
                                    @endcan

                                    @can('update', $item)
                                        <a href="{{ route('ranks.items.edit', $item) }}" class="{{ $component->link() }}" data-cy="edit">
                                            @icon('edit', $component->icon())
                                            <span>Edit</span>
                                        </a>
                                    @endcan

                                    @can('delete', $item)
                                        <div class="{{ $component->divider() }}"></div>
                                        <button
                                            x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($item) }});"
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
                No rank items found
            </x-search-not-found>
        @endforelse
        </ul>

        <div class="px-4 py-2 border-t border-gray-200 | sm:px-6 sm:py-3">
            {{ $items->withQueryString()->links() }}
        </div>
    </x-panel>

    <x-modal color="red" headline="Delete rank name?" icon="warning" :url="route('ranks.items.delete')">
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
