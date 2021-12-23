@extends($meta->template)

@section('content')
    <x-page-header title="Forms">
        <x-slot name="controls">
            @can('create', 'Nova\Forms\Models\Form')
                <x-link :href="route('forms.create')" color="blue" data-cy="create">
                    Add Form
                </x-link>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-content-box height="xs">
            <x-search-filter placeholder="Find a form..." :search="$search" />
        </x-content-box>

        <ul>
            @forelse ($forms as $form)
                <li class="border-t border-gray-6 hover:bg-gray-2 transition ease-in-out duration-200" data-id="{{ $form->id }}">
                    <div class="block">
                        <div class="px-4 py-4 flex items-center sm:px-6">
                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <div class="font-medium truncate">
                                        {{ $form->name }}
                                    </div>
                                    {{-- <div class="mt-2 flex flex-col space-y-2 sm:flex-row sm:space-x-6 sm:space-y-0">
                                        @if ($form->active_users_count > 0)
                                            <div class="flex items-center text-sm text-gray-11">
                                                @if ($form->active_users_count === 1)
                                                    @icon('user', 'shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                                @else
                                                    @icon('users', 'shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                                @endif
                                                <span>
                                                    {{ $form->active_users_count }} active @choice('user|users', $form->active_users_count)
                                                </span>
                                            </div>
                                        @endif

                                        @if ($form->inactive_users_count > 0)
                                            <div class="flex items-center text-sm text-gray-11">
                                                @if ($form->inactive_users_count === 1)
                                                    @icon('user', 'shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                                @else
                                                    @icon('users', 'shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                                @endif
                                                <span>
                                                    {{ $form->inactive_users_count }} inactive @choice('user|users', $form->inactive_users_count)
                                                </span>
                                            </div>
                                        @endif

                                        @if ($form->default)
                                            <div class="flex items-center text-sm text-gray-11">
                                                @icon('check', 'shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                                <span>Assigned to new users</span>
                                            </div>
                                        @endif
                                    </div> --}}
                                </div>
                                {{-- <div class="mt-4 shrink-0 sm:mt-0">
                                    <x-avatar-group size="xs" :items="$form->users->take(4)" />
                                </div> --}}
                            </div>
                            <div class="ml-5 shrink-0 leading-0">
                                <x-dropdown placement="bottom-end">
                                    <x-slot name="trigger">
                                        <x-icon.more class="h-6 w-6" />
                                    </x-slot>

                                    <x-dropdown.group>
                                        @can('view', $form)
                                            <x-dropdown.item :href="route('forms.show', $form)" icon="show" data-cy="view">
                                                <span>View</span>
                                            </x-dropdown.item>
                                        @endcan

                                        @can('update', $form)
                                            <x-dropdown.item :href="route('forms.edit', $form)" icon="edit" data-cy="edit">
                                                <span>Edit</span>
                                            </x-dropdown.item>
                                        @endcan

                                        @can('duplicate', $form)
                                            <x-dropdown.item type="button" icon="copy" @click="$dispatch('dropdown-toggle');$dispatch('modal-duplicate', {{ json_encode($form) }});" data-cy="duplicate">
                                                <span>Duplicate</span>
                                            </x-dropdown.item>
                                        @endcan

                                        {{-- @can('duplicate', $form)
                                            <x-dropdown.item type="submit" form="duplicate-{{ $form->id }}" icon="copy" data-cy="duplicate">
                                                <span>Duplicate</span>

                                                <x-slot name="buttonForm">
                                                    <x-form :action="route('forms.duplicate', $form)" id="duplicate-{{ $form->id }}" class="hidden" />
                                                </x-slot>
                                            </x-dropdown.item>
                                        @endcan --}}
                                    </x-dropdown.group>

                                    @can('update', $form)
                                        <x-dropdown.group>
                                            <x-dropdown.item :href="route('forms.edit', $form)" icon="wrench" data-cy="edit">
                                                <span>Design</span>
                                            </x-dropdown.item>
                                        </x-dropdown.group>
                                    @endcan

                                    @can('delete', $form)
                                        <x-dropdown.group>
                                            <x-dropdown.item-danger type="button" icon="delete" data-cy="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($form) }});">
                                                <span>Delete</span>
                                            </x-dropdown.item-danger>
                                        </x-dropdown.group>
                                    @endcan

                                    @if ($form->locked)
                                        <x-dropdown.group>
                                            <x-dropdown.text>
                                                This form is locked and cannot be duplicated or deleted.
                                            </x-dropdown.text>
                                        </x-dropdown.group>
                                    @endif
                                </x-dropdown>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <x-search-not-found>
                    No forms found
                </x-search-not-found>
            @endforelse
        </ul>

        <div class="px-4 py-2 border-t border-gray-6 sm:px-6 sm:py-3">
            {{ $forms->withQueryString()->links() }}
        </div>
    </x-panel>

    <x-tips section="forms" />

    <x-modal color="red" title="Delete Form?" icon="warning" :url="route('forms.delete')">
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
