@extends($__novaTemplate)

@section('content')
    <x-page-header title="Themes">
        <x-slot name="controls">
            <dropdown class="flex items-center text-gray-400 dark:text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150 mr-4" placement="bottom-end">
                <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>

                <template #dropdown="{ toggle }">
                    <div class="dropdown-text uppercase tracking-wide font-semibold text-gray-500">
                        Filter themes
                    </div>
                    <a href="{{ route('themes.index') }}" class="dropdown-link">All themes</a>
                    <a href="{{ route('themes.index') }}?pending" class="dropdown-link">Pending themes</a>
                </template>
            </dropdown>

            @can('create', 'Nova\Themes\Models\Theme')
            <a href="{{ route('themes.create') }}" class="button button-primary">
                Add Theme
            </a>
            @endcan
        </x-slot>
    </x-page-header>

    <div class="mt-12 grid gap-6 max-w-lg mx-auto | lg:grid-cols-3 lg:max-w-none">
    @foreach ($themes as $theme)
        <x-card x-data="{ id: {{ $theme->id }} }">
            <x-slot name="header">
                <div class="flex-shrink-0">
                    <img class="h-48 w-full object-cover" src="https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80" alt="" />
                </div>
            </x-slot>

            <div class="flex items-center justify-between">
                <h3 class="text-xl leading-7 font-semibold text-gray-900 dark:text-gray-100">
                    {{ $theme->name }}
                </h3>

                <dropdown class="flex items-center text-gray-400 dark:text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150" placement="bottom-end">
                    @icon('more', 'h-6 w-6')

                    <template #dropdown="{ toggle }">
                        @if (! $theme->exists)
                            <a href="#" class="dropdown-link">
                                @icon('edit', 'dropdown-icon')
                                Install
                            </a>
                        @else
                            @can('update', $theme)
                                <a href="{{ route('themes.edit', $theme) }}" class="dropdown-link">
                                    @icon('edit', 'dropdown-icon')
                                    Edit
                                </a>
                                <a href="#" class="dropdown-link">
                                    @icon('star', 'dropdown-icon')
                                    Make System Default
                                </a>
                            @endcan

                            @can('delete', $theme)
                                <button
                                    v-on:click="toggle();$emit('open-modal', {{ json_encode($theme) }});"
                                    class="dropdown-link"
                                >
                                    @icon('delete', 'dropdown-icon')
                                    Delete
                                </button>
                            @endcan
                        @endif
                    </template>
                </dropdown>
            </div>
            <p class="mt-1 flex items-center text-base leading-6 text-gray-500 dark:text-gray-400">
                @icon('folder', 'flex-shrink-0 mr-2 h-5 w-5 text-gray-400 dark:text-gray-500')
                themes/{{ $theme->location }}
            </p>
            @if (! $theme->exists)
                <span class="mt-2 badge badge-sm">
                    Pending
                </span>
            @else
                @if ($theme->active)
                    <span class="mt-2 badge badge-sm badge-success">Active</span>
                @else
                    <span class="mt-2 badge badge-sm badge-danger">Inactive</span>
                @endif
            @endif
        </x-card>
    @endforeach
    </div>

    <div class="text-center mt-12 text-sm text-gray-600 font-medium">
        Looking for more themes? Check out <a href="https://xtras.anodyne-productions.com" class="text-primary-500 hover:text-primary-600 transition ease-in-out duration-150">AnodyneXtras</a>!
    </div>

    <modal title="Delete theme?" color="danger">
        <template #icon>
            @icon('warning', 'h-6 w-6 text-danger-600')
        </template>

        <template #advanced="{ item }">
            <form :action="`themes/${item.id}`" method="POST" role="form" id="form">
                @csrf
                @method('delete')

                Are you sure you want to delete the @{{ item.name }} theme?
            </form>
        </template>

        <template #footer="{ close }">
            <span class="flex w-full | sm:col-start-2">
                <button form="form" class="button button-danger w-full">
                    Delete
                </button>
            </span>
            <span class="mt-3 flex w-full | sm:mt-0 sm:col-start-1">
                <button @click="close" type="button" class="button w-full">
                    Cancel
                </button>
            </span>
        </template>
    </modal>
@endsection
