<x-page-header title="Themes">
    <x-slot name="controls">
        @can('create', 'Nova\Themes\Models\Theme')
        <a href="{{ route('themes.create') }}" class="button button-primary">
            Add Theme
        </a>
        @endcan
    </x-slot>
</x-page-header>

<div class="mt-12 grid gap-6 max-w-lg mx-auto | lg:grid-cols-3 lg:max-w-none">
@foreach ($themes as $theme)
    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
        <a href="{{ route('themes.edit', $theme) }}" class="flex-shrink-0">
            <img class="h-48 w-full object-cover" src="https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80" alt="" />
        </a>
        <div class="flex-1 bg-white flex flex-col justify-between">
            <a href="{{ route('themes.edit', $theme) }}" class="flex-1 p-6">
                <div class="block">
                    <h3 class="text-xl leading-7 font-semibold text-gray-900">
                        {{ $theme->name }}
                    </h3>
                    <p class="mt-1 flex items-center text-base leading-6 text-gray-500">
                        @icon('folder', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                        themes/{{ $theme->location }}
                    </p>
                </div>
            </a>
            <div class="px-6 py-3 flex items-center justify-between bg-gray-50 border-t border-gray-100">
                <div class="flex-shrink-0">
                    <a href="#">
                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                    </a>
                </div>
                <div class="ml-3">
                    <dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500">
                        @icon('more', 'h-6 w-6')

                        <template #dropdown="{ toggle, styles }">
                            {{-- @can('view', $theme)
                                <a href="{{ route('themes.show', $theme) }}" :class="styles.link">
                                    <span :class="styles.icon">
                                        @icon('show')
                                    </span>
                                    View
                                </a>
                            @endcan --}}

                            @can('update', $theme)
                                <a href="{{ route('themes.edit', $theme) }}" :class="styles.link">
                                    <span :class="styles.icon">
                                        @icon('edit')
                                    </span>
                                    Edit
                                </a>
                            @endcan

                            @can('delete', $theme)
                                <div :class="styles.divider"></div>

                                <button :class="styles.dangerLink">
                                    <span :class="styles.dangerIcon">
                                        @icon('delete')
                                    </span>
                                    Delete
                                </button>
                            @endcan
                        </template>
                    </dropdown>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>

{{-- <modal
    :open="modalIsShown"
    title="Delete theme?"
    @close="hideModal"
    >
    Are you sure you want to delete the {{ deletingItem.title }} theme?

    <template #footer>
        <button
        type="button"
        class="button button-danger | sm:ml-3"
        data-cy="delete-theme"
        @click="remove"
        >
        Delete Theme
    </button>

    <button
    type="button"
    class="button mt-3 | sm:mt-0"
    @click="hideModal"
    >
    Cancel
</button>
</template>
</modal> --}}
