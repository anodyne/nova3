@extends($__novaTemplate)

@section('content')
    <x-page-header>
        <x-slot name="title">
            @if (request()->has('status'))
                {{ ucfirst(request()->status) }}
            @endif
            Characters
        </x-slot>

        <x-slot name="controls">
            <x-dropdown placement="bottom-end" class="flex items-center mr-4 text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150 {{ request()->has('type') ? 'text-blue-500' : '' }}" wide="true">
                @icon('filter', 'h-6 w-6')

                <x-slot name="dropdown">
                    <a href="{{ route('characters.index', 'status='.request('status').'&hasuser=1') }}" class="{{ $component->link() }} justify-between">
                        <span>Assigned to a user</span>
                        @if (request()->has('hasuser'))
                            @icon('check', 'h-5 w-5')
                        @endif
                    </a>
                    <a href="{{ route('characters.index', 'status='.request('status').'&nouser=1') }}" class="{{ $component->link() }} justify-between">
                        <span>Not assigned to a user</span>
                        @if (request()->has('nouser'))
                            @icon('check', 'h-5 w-5')
                        @endif
                    </a>
                    <a href="{{ route('characters.index', 'status='.request('status').'&noposition=1') }}" class="{{ $component->link() }} justify-between">
                        <span>Not assigned a position</span>
                        @if (request()->has('noposition'))
                            @icon('check', 'h-5 w-5')
                        @endif
                    </a>

                    <div class="{{ $component->divider() }}"></div>

                    <div class="{{ $component->text() }} uppercase tracking-wide font-semibold text-gray-500">
                        Filter by character type
                    </div>

                    <a href="{{ route('characters.index', 'status='.request('status')) }}" class="{{ $component->link() }}">All character types</a>
                    <a href="{{ route('characters.index', 'status='.request('status').'&type=primary') }}" class="{{ $component->link() }} justify-between">
                        <span>Primary characters</span>
                        @if (request('type') === 'primary')
                            @icon('check', 'h-5 w-5')
                        @endif
                    </a>
                    <a href="{{ route('characters.index', 'status='.request('status').'&type=secondary') }}" class="{{ $component->link() }} justify-between">
                        <span>Secondary characters</span>
                        @if (request('type') === 'secondary')
                            @icon('check', 'h-5 w-5')
                        @endif
                    </a>
                    <a href="{{ route('characters.index', 'status='.request('status').'&type=support') }}" class="{{ $component->link() }} justify-between">
                        <span>Support characters</span>
                        @if (request('type') === 'support')
                            @icon('check', 'h-5 w-5')
                        @endif
                    </a>
                </x-slot>
            </x-dropdown>

            @can('create', 'Nova\Characters\Models\Character')
                <a href="{{ route('characters.create') }}" class="button button-primary" data-cy="create">
                    Add Character
                </a>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
        <div>
            <div class="p-4 | sm:hidden">
                <select x-on:change="window.location.replace($event.target.value)" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 transition ease-in-out duration-150">
                    <option value="{{ route('characters.index', 'status=active') }}"{{ request()->status === 'active' ? 'selected' : '' }}>Active Characters</option>
                    <option value="{{ route('characters.index', 'status=pending') }}"{{ request()->status === 'pending' ? 'selected' : '' }}>Pending Characters</option>
                    <option value="{{ route('characters.index', 'status=inactive') }}"{{ request()->status === 'inactive' ? 'selected' : '' }}>Inactive Characters</option>
                    <option value="{{ route('characters.index') }}"{{ !request()->has('status') ? 'selected' : '' }}>All Characters</option>
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200 px-4 | sm:px-6">
                    <nav class="-mb-px flex">
                        <a
                            href="{{ route('characters.index', 'status=active') }}"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none @if (request()->status === 'active') border-blue-500 text-blue-600 @else text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif"
                        >
                            Active
                        </a>
                        <a
                            href="{{ route('characters.index', 'status=pending') }}"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none @if (request()->status === 'pending') border-blue-500 text-blue-600 @else text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif"
                        >
                            Pending
                        </a>
                        <a
                            href="{{ route('characters.index', 'status=inactive') }}"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none @if (request()->status === 'inactive') border-blue-500 text-blue-600 @else text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif"
                        >
                            Inactive
                        </a>
                        <a
                            href="{{ route('characters.index') }}"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none @if (!request()->has('status')) border-blue-500 text-blue-600 @else text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif"
                        >
                            All Characters
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <div class="px-4 py-2 | sm:px-6 sm:py-3">
            <x-search-filter placeholder="Find a character..." :search="$search" />
        </div>

        <ul>
        @forelse ($characters as $character)
            <li class="border-t border-gray-200">
                <div class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                    <div class="flex items-center px-4 py-4 | sm:px-6">
                        <div class="min-w-0 flex-1 flex items-center">
                            <div class="min-w-0 flex-1 pr-4 | md:grid md:grid-cols-2 md:gap-4">
                                <div>
                                    <x-avatar-meta :url="$character->avatar_url">
                                        <x-slot name="primaryMeta">
                                            {{ optional(optional($character->rank)->name)->name }}
                                            {{ $character->name }}
                                        </x-slot>

                                        <x-slot name="secondaryMeta">
                                            {{ $character->positions->implode('name', ' & ') }}
                                        </x-slot>
                                    </x-avatar-meta>
                                </div>
                                <div>
                                    <div class="flex">
                                        <x-badge size="sm" :type="$character->type->color()">
                                            {{ $character->type->displayName() }}
                                        </x-badge>
                                    </div>
                                    @if ($character->users->count() > 0)
                                        <div class="hidden mt-2 items-center text-sm leading-5 text-gray-500 | sm:flex">
                                            @if ($character->users->count() === 1)
                                                @icon('user', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                                            @else
                                                @icon('users', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                                            @endif

                                            <span>
                                                Played by {{ $character->users->implode('name', ' & ') }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="leading-0">
                            <x-dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500">
                                @icon('more', 'h-6 w-6')

                                <x-slot name="dropdown">
                                    @can('view', $character)
                                        <a href="{{ route('characters.show', $character) }}" class="{{ $component->link() }}" data-cy="view">
                                            @icon('show', $component->icon())
                                            <span>View</span>
                                        </a>
                                    @endcan

                                    @can('update', $character)
                                        <a href="{{ route('characters.edit', $character) }}" class="{{ $component->link() }}" data-cy="edit">
                                            @icon('edit', $component->icon())
                                            <span>Edit</span>
                                        </a>
                                    @endcan

                                    @can('activate', $character)
                                        <div class="{{ $component->divider() }}"></div>
                                        <x-form :action="route('characters.activate', $character)" id="activate"></x-form>
                                        <button
                                            type="submit"
                                            form="activate"
                                            class="{{ $component->link() }}"
                                            data-cy="activate"
                                        >
                                            @icon('check-alt', $component->icon())
                                            <span>Activate</span>
                                        </button>
                                    @endcan

                                    @can('deactivate', $character)
                                        <div class="{{ $component->divider() }}"></div>
                                        <button
                                            x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-deactivate', {{ json_encode($character) }});"
                                            type="button"
                                            form="deactivate"
                                            class="{{ $component->link() }}"
                                            data-cy="deactivate"
                                        >
                                            @icon('remove-alt', $component->icon())
                                            <span>Deactivate</span>
                                        </button>
                                    @endcan

                                    @can('delete', $character)
                                        <div class="{{ $component->divider() }}"></div>
                                        <button
                                            x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($character) }});"
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
                No characters found
            </x-search-not-found>
        @endforelse
        </ul>

        <div class="px-4 py-2 border-t border-gray-200 | sm:px-6 sm:py-3">
            {{ $characters->withQueryString()->links() }}
        </div>
    </x-panel>

    <x-tips section="characters" />

    <x-modal color="red" title="Delete character?" icon="warning" :url="route('characters.delete')">
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

    <x-modal color="blue" title="Deactivate character?" icon="duplicate" :url="route('characters.confirm-deactivate')" event="modal-deactivate">
        <x-slot name="footer">
            <span class="flex w-full | sm:col-start-2">
                <button form="form-deactivate" class="button button-primary w-full">
                    Deactivate
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
