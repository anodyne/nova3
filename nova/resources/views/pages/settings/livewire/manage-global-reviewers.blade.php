<x-panel>
    <x-spacing size="3xs" class="relative">
        <x-select
            wire:model.live.debounce="selected"
            variant="combobox"
            placeholder="Find a user to add as a reviewer..."
            clearable
        >
            @foreach ($models as $model)
                <x-select.option :value="$model->id">
                    <div class="flex items-center gap-2.5">
                        <x-status :status="$model->status" />
                        {{ $model->name }}
                    </div>
                </x-select.option>
            @endforeach
        </x-select>
    </x-spacing>

    @if ($reviewers->count() > 0)
        <x-spacing.group divided>
            @foreach ($reviewers as $user)
                <x-spacing class="flex items-center justify-between" size="row" wire:key="row-{{ $user->id }}">
                    <div>
                        <x-avatar.user :$user>
                            @if ($user->hasPermission('application.approve'))
                                <x-slot name="subtitle">
                                    <x-text size="sm" class="text-primary-500 font-medium">
                                        Can approve applications
                                    </x-text>
                                </x-slot>
                            @endif
                        </x-avatar.user>
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <x-dropdown placement="bottom end">
                            <x-slot name="trigger">
                                <x-button type="button" variant="subtle" inset="right" square data-danger>
                                    <x-icon :name="Tabler::Trash" size="sm" />
                                </x-button>
                            </x-slot>

                            <x-dropdown.group>
                                <x-dropdown.text>
                                    Are you sure you want to unassign
                                    <strong>
                                        {{ $user->name }}
                                    </strong>
                                    as a global reviewer?
                                </x-dropdown.text>
                            </x-dropdown.group>
                            <x-dropdown.group>
                                <x-dropdown.item
                                    type="button"
                                    :icon="Tabler::Trash"
                                    wire:click="remove({{ $user->id }})"
                                    variant="danger"
                                >
                                    Unassign
                                </x-dropdown.item>
                                <x-dropdown.item
                                    type="button"
                                    :icon="Tabler::Ban"
                                    x-on:click.prevent="$dispatch('dropdown-close')"
                                >
                                    Cancel
                                </x-dropdown.item>
                            </x-dropdown.group>
                        </x-dropdown>
                    </div>
                </x-spacing>
            @endforeach
        </x-spacing.group>
    @else
        <x-empty>
            <x-illustration :name="Illustration::Users" />
            <x-empty.heading>No users assigned as reviewers</x-empty.heading>
            <x-empty.text>Get started by assigning a user as a reviewer</x-empty.text>
        </x-empty>
    @endif

    <input type="hidden" name="global_reviewers" value="{{ $globalReviewers }}" />
</x-panel>
