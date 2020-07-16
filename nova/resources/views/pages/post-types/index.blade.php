@extends($__novaTemplate)

@section('content')
    <x-page-header title="Post Types">
        <x-slot name="controls">
            @can('update', $postTypes->first())
                <a href="{{ route('post-types.index', 'reorder') }}" class="flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150 mx-4">
                    @icon('arrow-sort', 'h-6 w-6')
                </a>
            @endcan

            @can('create', 'Nova\PostTypes\Models\PostType')
                <a href="{{ route('post-types.create') }}" class="button button-primary" data-cy="create">
                    Add Post Type
                </a>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel x-data="sortableList()" x-init="initSortable()">
        @if ($isReordering)
            <div class="bg-info-100 border-t border-b border-info-200 p-4 | sm:rounded-t-md sm:border-t-0">
                <div class="flex">
                    <div class="flex-shrink-0">
                        @icon('arrow-sort', 'h-6 w-6 text-info-600')
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm leading-5 font-medium text-info-900">
                            Change Sorting Order
                        </h3>
                        <div class="mt-2 text-sm leading-5 text-info-800">
                            <p>Post types appear in the order you set in Nova's writing features. To change the sorting of the post types, drag them to the desired order and then click Save Sort Order below.</p>
                        </div>
                        <div class="mt-4">
                            <x-form :action="route('post-types.reorder')" id="form-reorder">
                                <input type="hidden" name="sort" x-model="newSortOrder">
                                <div class="flex items-center space-x-4">
                                    <button type="submit" form="form-reorder" class="button button-info">Save Sort Order</button>
                                    <a href="{{ route('post-types.index') }}" class="text-info-600 text-sm font-medium transition ease-in-out duration-150 hover:text-info-800">
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
                <x-search-filter placeholder="Find a post type..." :search="$search" />
            </div>
        @endif

        <ul id="sortable-list">
        @forelse ($postTypes as $postType)
            <li class="sortable-item border-t border-gray-200 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out @if ($isReordering) first:border-0 last:rounded-b-md @endif" data-id="{{ $postType->id }}">
                <div class="block">
                    <div class="px-4 py-4 flex items-center | sm:px-6">
                        @if ($isReordering)
                            <div class="sortable-handle flex-shrink-0 cursor-move mr-5">
                                @icon('reorder', 'h-5 w-5 text-gray-400')
                            </div>
                        @endif
                        <div class="min-w-0 flex-1 | sm:flex sm:flex-col">
                            <div class="leading-normal font-medium truncate">
                                {{ $postType->name }}
                            </div>
                            <p class="text-sm leading-5 text-gray-600">{{ $postType->description }}</p>
                        </div>
                        <div class="ml-5 flex-shrink-0 leading-0">
                            <x-dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500">
                                @icon('more', 'h-6 w-6')

                                <x-slot name="dropdown">
                                    @can('view', $postType)
                                        <a href="{{ route('post-types.show', $postType) }}" class="{{ $component->link() }}" data-cy="view">
                                            @icon('show', $component->icon())
                                            <span>View</span>
                                        </a>
                                    @endcan

                                    @can('update', $postType)
                                        <a href="{{ route('post-types.edit', $postType) }}" class="{{ $component->link() }}" data-cy="edit">
                                            @icon('edit', $component->icon())
                                            <span>Edit</span>
                                        </a>
                                    @endcan

                                    @can('duplicate', $postType)
                                        {{-- <button type="submit" class="{{ $component->link() }}" form="duplicate-{{ $postType->id }}" data-cy="duplicate">
                                            @icon('duplicate', $component->icon())
                                            <span>Duplicate</span>
                                        </button>
                                        <x-form :action="route('post-types.duplicate', $postType)" id="duplicate-{{ $postType->id }}" class="hidden" /> --}}
                                    @endcan

                                    @can('delete', $postType)
                                        <div class="{{ $component->divider() }}"></div>
                                        <button
                                            x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($postType) }});"
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
                No post types found
            </x-search-not-found>
        @endforelse
        </ul>

        @if (! $isReordering)
            <div class="px-4 py-2 border-t border-gray-200 | sm:px-6 sm:py-3">
                {{ $postTypes->withQueryString()->links() }}
            </div>
        @endif
    </x-panel>

    <x-tips section="post-types" />

    <x-modal color="red" title="Delete Post Type?" icon="warning" :url="route('post-types.delete')">
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
