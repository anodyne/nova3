<x-panel>
    <x-panel.header title="Forms" message="Organize character positions into logical groups that you can display on your manifests.">
        <x-slot:actions>
            @if ($forms->count() > 0)
                @can('create', $formClass)
                    <x-button.filled :href="route('forms.create')" class="order-first md:order-last" leading="add">
                        Add
                    </x-button.filled>
                @endcan
            @endif
        </x-slot:actions>
    </x-panel.header>

    @if ($formCount === 0)
        <x-empty-state.large
            icon="list"
            title="Start by creating a form"
            message="Departments allow you to organize character positions into logical groups that you can display on your manifests."
            label="Add a form"
            :link="route('forms.create')"
            :link-access="gate()->allows('create', $formClass)"
        ></x-empty-state.large>
    @else
        <x-content-box height="sm" class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6">
            <div class="flex-1">
                <x-input.group>
                    <x-input.text placeholder="Find forms by name" wire:model="search">
                        <x-slot:leadingAddOn>
                            <x-icon name="search" size="sm"></x-icon>
                        </x-slot:leadingAddOn>

                        @if ($search)
                            <x-slot:trailingAddOn>
                                <x-button.text tag="button" color="gray" wire:click="$set('search', '')">
                                    <x-icon name="dismiss" size="sm"></x-icon>
                                </x-button.text>
                            </x-slot:trailingAddOn>
                        @endif
                    </x-input.text>
                </x-input.group>
            </div>
        </x-content-box>
    @endif
@endif

<x-table-list columns="1">
    @if ($formCount > 0)
        @if ($forms->count() > 0)
            <x-slot:header>
                <div>Name</div>
                {{-- <div>Status</div> --}}
            </x-slot:header>
        @endif

        @forelse ($forms as $form)
            <x-table-list.row wire:key="form-{{ $form->id }}">
                <div class="flex items-center">
                    <x-table-list.primary-column>
                        {{ $form->name }}
                    </x-table-list.primary-column>
                </div>

                {{-- <div @class([
                    'flex items-center',
                ])>
                    <x-badge :color="$form->status->color()">
                        {{ $form->status->displayName() }}
                    </x-badge>
                </div> --}}

                <x-slot:actions>
                    <x-dropdown placement="bottom-end">
                        <x-slot:trigger>
                            <x-icon.more class="h-6 w-6" />
                        </x-slot:trigger>

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
                                <x-dropdown.item type="button" icon="copy" x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-duplicate', {{ json_encode($form) }});" data-cy="duplicate">
                                    <span>Duplicate</span>
                                </x-dropdown.item>
                            @endcan

                            {{-- @can('duplicate', $form)
                                <x-dropdown.item type="submit" form="duplicate-{{ $form->id }}" icon="copy" data-cy="duplicate">
                                    <span>Duplicate</span>

                                    <x-slot:buttonForm>
                                        <x-form :action="route('forms.duplicate', $form)" id="duplicate-{{ $form->id }}" class="hidden" />
                                    </x-slot:buttonForm>
                                </x-dropdown.item>
                            @endcan --}}
                        </x-dropdown.group>

                        @can('update', $form)
                            <x-dropdown.group>
                                <x-dropdown.item :href="route('forms.edit', $form)" icon="tools" data-cy="edit">
                                    <span>Design</span>
                                </x-dropdown.item>
                            </x-dropdown.group>
                        @endcan

                        @can('delete', $form)
                            <x-dropdown.group>
                                <x-dropdown.item-danger type="button" icon="trash" data-cy="delete" x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($form) }});">
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
                </x-slot:actions>
            </x-table-list.row>
        @empty
            <x-slot:emptyMessage>
                <x-empty-state.not-found
                    entity="form"
                    :search="$search"
                    :primary-access="gate()->allows('create', $formClass)"
                >
                    <x-slot:primary>
                        <x-button.filled :href="route('forms.create')" color="primary">
                            Add a form
                        </x-button.filled>
                    </x-slot:primary>

                    <x-slot:secondary>
                        <x-button.outline wire:click="$set('search', '')" color="gray">Clear search</x-button.outline>
                    </x-slot:secondary>
                </x-empty-state.not-found>
            </x-slot:emptyMessage>
        @endforelse

        @if ($forms->count() > 0)
            <x-slot:footer>
                {{ $forms->withQueryString()->links() }}
            </x-slot:footer>
        @endif
    </x-table-list>
</x-panel>
