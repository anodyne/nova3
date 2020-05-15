@extends($__novaTemplate)

@section('content')
    <x-page-header title="Themes">
        <x-slot name="controls">
            @can('create', 'Nova\Themes\Models\Theme')
            <a href="{{ route('themes.create') }}" class="button button-primary">
                Add Theme
            </a>
            @endcan
        </x-slot>
    </x-page-header>

    @if ($pendingThemes->count() > 0)
        <div class="bg-gray-200 dark:bg-gray-900 overflow-hidden rounded-lg">
            <div class="px-4 py-5 | sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Themes to be installed
                </h3>

                <div class="mt-4 grid gap-6 max-w-lg mx-auto | lg:grid-cols-3 lg:max-w-none">
                @foreach ($pendingThemes as $pendingTheme)
                    <x-card>
                        <x-slot name="header">
                            <div class="flex-shrink-0">
                                <img class="h-48 w-full object-cover" src="https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80" alt="" />
                            </div>
                        </x-slot>

                        <h3 class="text-xl leading-7 font-semibold text-gray-900">
                            {{ $pendingTheme['name'] }}
                        </h3>
                        <p class="mt-1 flex items-center text-base leading-6 text-gray-500">
                            @icon('folder', 'flex-shrink-0 mr-2 h-5 w-5 text-gray-400')
                            themes/{{ $pendingTheme['location'] }}
                        </p>

                        <form action="">
                            <button type="button" class="mt-4 button button-xs">
                                Install
                            </button>
                        </form>
                    </x-card>
                @endforeach
                </div>
            </div>
        </div>
    @endif

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
                    </template>
                </dropdown>
            </div>
            <p class="mt-1 flex items-center text-base leading-6 text-gray-500 dark:text-gray-400">
                @icon('folder', 'flex-shrink-0 mr-2 h-5 w-5 text-gray-400 dark:text-gray-500')
                themes/{{ $theme->location }}
            </p>
        </x-card>
    @endforeach
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
