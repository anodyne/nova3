@extends($__novaTemplate)

@section('content')
    <x-page-header>
        <x-slot name="title">
            {{ request()->has('pending') ? 'Pending ' : '' }}Themes
        </x-slot>

        <x-slot name="controls">
            <x-dropdown placement="bottom-end" class="flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150 mx-4 {{ request()->has('pending') ? 'text-blue-500' : '' }}">
                <x-slot name="trigger">@icon('filter', 'h-6 w-6')</x-slot>

                <div class="{{ $component->text() }} uppercase tracking-wide font-semibold text-gray-500">
                    Filter themes
                </div>
                <a href="{{ route('themes.index') }}" class="{{ $component->link() }}">All themes</a>
                <a href="{{ route('themes.index') }}?pending" class="{{ $component->link() }}">Pending themes</a>
            </x-dropdown>

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
                            <img class="h-48 w-full object-cover rounded-t-md" src="{{ asset("themes/{$theme->location}/{$theme->preview}") }}" alt="" />
                        </div>
                    </x-slot>

                    <div class="flex items-center justify-between">
                        <h3 class="inline-flex items-center text-xl font-semibold text-gray-900">
                            {{ $theme->name }}
                        </h3>

                        <x-dropdown placement="bottom-end" class="flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150">
                            <x-slot name="trigger">@icon('more', 'h-6 w-6')</x-slot>

                            @if (! $theme->exists)
                                <button
                                    class="{{ $component->link() }}"
                                    type="submit"
                                    form="install-form-{{ $theme->location }}"
                                    role="menuitem"
                                >
                                    @icon('arrow-right-alt', $component->icon())
                                    <span>Install</span>
                                </button>

                                <x-form :action="route('themes.install')" id="install-form-{{ $theme->location }}">
                                    <input type="hidden" name="theme" value="{{ $theme->location }}">
                                </x-form>
                            @else
                                @can('update', $theme)
                                    <a href="{{ route('themes.edit', $theme) }}" class="{{ $component->link() }}">
                                        @icon('edit', $component->icon())
                                        <span>Edit</span>
                                    </a>
                                @endcan

                                @can('delete', $theme)
                                    <div class="{{ $component->divider() }}"></div>
                                    <button
                                        x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($theme) }});"
                                        class="{{ $component->link() }}"
                                    >
                                        @icon('delete', $component->icon())
                                        <span>Delete</span>
                                    </button>
                                @endcan
                            @endif
                        </x-dropdown>
                    </div>
                    <p class="mt-1 flex items-center text-base text-gray-500">
                        @icon('folder', 'flex-shrink-0 mr-2 h-5 w-5 text-gray-400')
                        themes/{{ $theme->location }}
                    </p>
                    @if (! $theme->exists)
                        <x-badge class="mt-2" size="sm" type="warning">Pending</x-badge>
                    @else
                        @if ($theme->active)
                            <x-badge class="mt-2" size="sm" type="success">Active</x-badge>
                        @else
                            <x-badge class="mt-2" size="sm">Inactive</x-badge>
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
                    <p class="text-sm text-blue-700">
                        Looking for more themes? Check out AnodyneXtras!
                    </p>
                    <p class="mt-3 text-sm | md:mt-0 md:ml-6">
                        <a href="{{ config('services.anodyne.links.xtras') }}" target="_blank" class="whitespace-no-wrap font-medium text-blue-700 hover:text-blue-600 transition ease-in-out duration-150">
                            Go &rarr;
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <x-modal color="red" title="Delete Theme?" icon="warning" :url="route('themes.delete')">
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
