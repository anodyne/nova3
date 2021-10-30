@extends($meta->template)

@section('content')
    <x-page-header>
        <x-slot name="title">
            {{ request()->has('pending') ? 'Pending ' : '' }}Themes
        </x-slot>

        <x-slot name="controls">
            <x-dropdown placement="bottom-start md:bottom-end">
                <x-slot name="trigger">@icon('filter', 'h-7 w-7 md:h-6 md:w-6')</x-slot>

                <x-dropdown.group>
                    <x-dropdown.text class="uppercase tracking-wide font-semibold text-gray-11">
                        Filter themes
                    </x-dropdown.text>

                    <x-dropdown.item :href="route('themes.index')">All themes</x-dropdown.item>
                    <x-dropdown.item :href="route('themes.index', 'pending')">Pending themes</x-dropdown.item>
                </x-dropdown.group>
            </x-dropdown>

            @can('create', 'Nova\Themes\Models\Theme')
                <x-link :href="route('themes.create')" color="blue">
                    Add Theme
                </x-link>
            @endcan
        </x-slot>
    </x-page-header>

    @if ($themes->count() > 0)
        <div class="mt-12 grid gap-6 max-w-lg mx-auto lg:grid-cols-3 lg:max-w-none">
            @foreach ($themes as $theme)
                <x-panel x-data="{ id: {{ $theme->id ?? 0 }} }">
                    <div class="flex-shrink-0">
                        <img class="h-48 w-full object-cover md:rounded-t-md" src="{{ asset("themes/{$theme->location}/{$theme->preview}") }}" alt="" />
                    </div>

                    <x-content-box>
                        <div class="flex items-center justify-between">
                            <h3 class="inline-flex items-center text-xl font-semibold text-gray-12">
                                {{ $theme->name }}
                            </h3>

                            <x-dropdown placement="bottom-end">
                                <x-slot name="trigger">
                                    <x-icon.more class="h-6 w-6" />
                                </x-slot>

                                @if (! $theme->exists)
                                    <x-dropdown.group>
                                        <x-dropdown.item type="submit" icon="arrow-right-alt" form="install-form-{{ $theme->location }}">
                                            <span>Install</span>

                                            <x-slot name="buttonForm">
                                                <x-form :action="route('themes.install')" id="install-form-{{ $theme->location }}">
                                                    <input type="hidden" name="theme" value="{{ $theme->location }}">
                                                </x-form>
                                            </x-slot>
                                        </x-dropdown.item>
                                    </x-dropdown.group>
                                @else
                                    @can('update', $theme)
                                        <x-dropdown.group>
                                            <x-dropdown.item :href="route('themes.edit', $theme)" icon="edit">
                                                <span>Edit</span>
                                            </x-dropdown.item>
                                        </x-dropdown.group>
                                    @endcan

                                    @can('delete', $theme)
                                        <x-dropdown.group>
                                            <x-dropdown.item-danger type="button" icon="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($theme) }});">
                                                <span>Delete</span>
                                            </x-dropdown.item-danger>
                                        </x-dropdown.group>
                                    @endcan
                                @endif
                            </x-dropdown>
                        </div>
                        <p class="mt-1 flex items-center text-base text-gray-11">
                            @icon('folder', 'flex-shrink-0 mr-2 h-5 w-5 text-gray-9')
                            themes/{{ $theme->location }}
                        </p>
                        @if (! $theme->exists)
                            <x-badge class="mt-2" size="xs" color="yellow">Pending</x-badge>
                        @else
                            @if ($theme->active)
                                <x-badge class="mt-2" size="xs" color="green">Active</x-badge>
                            @else
                                <x-badge class="mt-2" size="xs" color="gray">Inactive</x-badge>
                            @endif
                        @endif
                    </x-content-box>
                </x-panel>
            @endforeach
        </div>
    @else
        <div class="flex items-center w-full rounded-md px-4 py-4 bg-yellow-3 sm:px-6">
            @icon('warning', 'h-6 w-6 flex-shrink-0 mr-3 text-yellow-9')
            <span class="font-medium text-yellow-11">
                No themes found.
            </span>
        </div>
    @endif

    <div class="w-full max-w-2xl mx-auto mt-16">
        <div class="rounded-md bg-blue-3 border border-blue-6 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    @icon('info', 'h-6 w-6 text-blue-9')
                </div>
                <div class="ml-3 flex-1 md:flex md:justify-between">
                    <p class="text-sm text-blue-11">
                        Looking for more themes? Check out the Nova Exchange!
                    </p>
                    <p class="mt-3 text-sm md:mt-0 md:ml-6">
                        <a href="{{ config('services.anodyne.links.exchange') }}" target="_blank" class="whitespace-nowrap font-medium text-blue-9 hover:text-blue-10 transition ease-in-out duration-200">
                            Go &rarr;
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <x-modal color="red" title="Delete Theme?" icon="warning" :url="route('themes.delete')">
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
