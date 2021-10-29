@extends($meta->template)

@section('content')
    <x-page-header title="Post Types">
        <x-slot name="controls">
            @can('update', $postTypes->first())
                <x-link :href="route('post-types.index', 'reorder')" color="gray-text" size="none">
                    @icon('arrow-sort', 'h-6 w-6')
                </x-link>
            @endcan

            @can('create', 'Nova\PostTypes\Models\PostType')
                <x-link :href="route('post-types.create')" color="blue" data-cy="create">
                    Add Post Type
                </x-link>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel x-data="sortableList">
        @if ($isReordering)
            <x-content-box class="bg-purple-3 border-t border-b border-purple-6 sm:rounded-t-md sm:border-t-0">
                <div class="flex">
                    <div class="flex-shrink-0">
                        @icon('arrow-sort', 'h-6 w-6 text-purple-9')
                    </div>
                    <div class="ml-3">
                        <h3 class="font-medium text-purple-11">
                            Change Sorting Order
                        </h3>
                        <div class="mt-2 text-sm text-purple-11">
                            <p>Post types appear in the order you set in Nova's writing features. To change the sorting of the post types, drag them to the desired order and then click Save Sort Order below.</p>
                        </div>
                        <div class="mt-4">
                            <x-form :action="route('post-types.reorder')" id="form-reorder" :divide="false">
                                <input type="hidden" name="sort" x-model="newSortOrder">
                                <div class="flex items-center space-x-4">
                                    <x-button type="submit" form="form-reorder" color="purple">Save Sort Order</x-button>
                                    <x-link :href="route('post-types.index')" color="purple-text" size="none">
                                        Cancel
                                    </x-link>
                                </div>
                            </x-form>
                        </div>
                    </div>
                </div>
            </x-content-box>
        @else
            <x-content-box height="xs">
                <x-search-filter placeholder="Find a post type..." :search="$search" />
            </x-content-box>
        @endif

        <ul id="sortable-list">
        @forelse ($postTypes as $postType)
            <li class="sortable-item border-t border-gray-6 hover:bg-gray-2 focus:outline-none focus:bg-gray-2 transition ease-in-out duration-200 @if ($isReordering) first:border-0 last:rounded-b-md @endif" data-id="{{ $postType->id }}">
                <div class="block">
                    <div class="px-4 py-4 flex items-center sm:px-6">
                        @if ($isReordering)
                            <div class="sortable-handle flex-shrink-0 cursor-move mr-5">
                                <x-icon.move-handle class="h-5 w-5 text-gray-9" />
                            </div>
                        @endif
                        <div class="flex min-w-0 flex-1">
                            <div class="flex-shrink-0 mr-3 mt-0.5" style="color:{{ $postType->color }}">
                                @isset($postType->icon)
                                    @icon($postType->icon, 'h-6 w-6')
                                @else
                                    <div class="h-6 w-6"></div>
                                @endisset
                            </div>
                            <div class="min-w-0 flex-1 sm:flex sm:flex-col">
                                <div class="flex items-center space-x-3">
                                    <div class="font-medium truncate">
                                        {{ $postType->name }}
                                    </div>

                                    @if ($postType->role)
                                        <x-badge size="xs" color="gray">{{ $postType->role->display_name }}</x-badge>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="ml-5 flex-shrink-0 leading-0">
                            <x-dropdown placement="bottom-end">
                                <x-slot name="trigger">
                                    <x-icon.more class="h-6 w-6" />
                                </x-slot>

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

                                            <x-slot name="buttonForm">
                                                <x-form :action="route('post-types.duplicate', $postType)" id="duplicate-{{ $postType->id }}" class="hidden" />
                                            </x-slot>
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
            <div class="px-4 py-2 border-t border-gray-6 sm:px-6 sm:py-3">
                {{ $postTypes->withQueryString()->links() }}
            </div>
        @endif
    </x-panel>

    <x-tips section="post-types" />

    <x-modal color="red" title="Delete Post Type?" icon="warning" :url="route('post-types.delete')">
        <x-slot name="footer">
            <span class="flex w-full sm:col-start-2">
                <x-button type="submit" form="form" color="red" full-width>
                    Delete
                </x-button>
            </span>
            <span class="mt-3 flex w-full sm:mt-0 sm:col-start-1">
                <x-button @click="$dispatch('modal-close')" type="button" color="white" full-width>
                    Cancel
                </x-button>
            </span>
        </x-slot>
    </x-modal>
@endsection
