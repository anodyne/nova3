@extends($__novaTemplate)

@section('content')
    <x-page-header title="Themes">
        <x-slot name="controls">
            <dropdown placement="bottom-end" class="flex items-center text-gray-400 dark:text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150 mx-4 {{ request()->has('pending') ? 'text-blue-500' : '' }}">
                @icon('filter', 'h-6 w-6')

                <template #dropdown>
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

    @if ($themes->count() > 0)
        <div class="mt-12 grid gap-6 max-w-lg mx-auto | lg:grid-cols-3 lg:max-w-none">
            @foreach ($themes as $theme)
                <x-card x-data="{ id: {{ $theme->id ?? 0 }} }">
                    <x-slot name="header">
                        <div class="flex-shrink-0">
                            <img class="h-48 w-full object-cover" src="{{ asset("themes/{$theme->location}/preview.webp") }}" alt="" />
                        </div>
                    </x-slot>

                    <div class="flex items-center justify-between">
                        <h3 class="inline-flex items-center text-xl leading-7 font-semibold text-gray-900 dark:text-gray-100">
                            @if ($theme->default)
                                @icon('star', 'h-5 w-5 text-blue-500 mr-2')
                            @endif
                            <span>{{ $theme->name }}</span>
                        </h3>

                        <dropdown placement="bottom-end" class="flex items-center text-gray-400 dark:text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150">
                            @icon('more', 'h-6 w-6')

                            <template #dropdown="{ toggle }">
                                @if (! $theme->exists)
                                    <button class="dropdown-link" type="submit" form="install-form-{{ $theme->location }}" role="menuitem">
                                        @icon('arrow-right-alt', 'dropdown-icon')
                                        Install
                                    </button>

                                    <form id="install-form-{{ $theme->location }}" action="{{ route('themes.install') }}" method="POST" class="hidden">
                                        @csrf
                                        <input type="hidden" name="theme" value="{{ $theme->location }}">
                                    </form>
                                @else
                                    @can('update', $theme)
                                        <a href="{{ route('themes.edit', $theme) }}" class="dropdown-link">
                                            @icon('edit', 'dropdown-icon')
                                            Edit
                                        </a>

                                        @if (! $theme->default)
                                            <a href="#" class="dropdown-link">
                                                @icon('star', 'dropdown-icon')
                                                Make System Default
                                            </a>
                                        @endif
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
                        <x-badge class="mt-2" size="sm">Pending</x-badge>
                    @else
                        @if ($theme->active)
                            <x-badge class="mt-2" size="sm" type="success">Active</x-badge>
                        @else
                            <x-badge class="mt-2" size="sm" type="danger">Inactive</x-badge>
                        @endif
                    @endif
                </x-card>
            @endforeach
        </div>
    @else
        <div class="flex items-center w-full rounded-md px-4 py-4 bg-warning-50 | sm:px-6">
            @icon('warning', 'h-6 w-6 flex-shrink-0 mr-3 text-warning-400')
            <span class="font-medium text-warning-600">
                No themes found.
            </span>
        </div>
    @endif

    <div class="w-full max-w-2xl mx-auto mt-16">
        <div class="rounded-md bg-blue-100 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    @icon('info', 'h-6 w-6 text-blue-500')
                </div>
                <div class="ml-3 flex-1 | md:flex md:justify-between">
                    <p class="text-sm leading-5 text-blue-700">
                        Looking for more themes? Check out AnodyneXtras!
                    </p>
                    <p class="mt-3 text-sm leading-5 | md:mt-0 md:ml-6">
                        <a href="{{ config('services.anodyne.links.xtras') }}" target="_blank" class="whitespace-no-wrap font-medium text-blue-700 hover:text-blue-600 transition ease-in-out duration-150">
                            Go &rarr;
                        </a>
                    </p>
                </div>
            </div>
        </div>
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
                <button v-on:click="close" type="button" class="button w-full">
                    Cancel
                </button>
            </span>
        </template>
    </modal>
@endsection
