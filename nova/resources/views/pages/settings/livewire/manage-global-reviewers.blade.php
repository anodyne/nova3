<x-panel>
    <x-spacing size="2xs">
        <x-panel.manage.search :$search placeholder="Find a user to add as a reviewer (type * to see all users)">
            <x-dropdown.group>
                @forelse ($searchResults as $user)
                    <x-panel.manage.result-item :value="$user->id" :text="$user->name"></x-panel.manage.result-item>
                @empty
                    <x-empty-state.small :icon="Icon::Users" title="No reviewer(s) found"></x-empty-state.small>
                @endforelse
            </x-dropdown.group>
        </x-panel.manage.search>
    </x-spacing>

    @if ($reviewers->count() > 0)
        <div class="divide-y divide-gray-950/5 dark:divide-white/5">
            @foreach ($reviewers as $user)
                <x-spacing class="flex items-center justify-between" size="row" wire:key="row-{{ $user->id }}">
                    <div>
                        <x-avatar.user :user="$user">
                            @if ($user->hasPermission('application.approve'))
                                <x-slot name="secondary">
                                    <x-text size="sm" class="text-primary-500 font-medium">
                                        Can approve applications
                                    </x-text>
                                </x-slot>
                            @endif
                        </x-avatar.user>
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <x-dropdown placement="bottom end" size="lg">
                            <x-slot name="trigger">
                                <x-button type="button" color="neutral-danger" size="none" text>
                                    <x-icon :name="Icon::Trash" size="sm"></x-icon>
                                </x-button>
                            </x-slot>

                            <x-dropdown.group>
                                <x-dropdown.text>
                                    Are you sure you want to unassign
                                    <strong class="font-semibold">
                                        {{ $user->name }}
                                    </strong>
                                    as a global reviewer?
                                </x-dropdown.text>
                            </x-dropdown.group>
                            <x-dropdown.group>
                                <x-dropdown.item
                                    type="button"
                                    :icon="Icon::Trash"
                                    wire:click="remove({{ $user->id }})"
                                    variant="danger"
                                >
                                    Unassign
                                </x-dropdown.item>
                                <x-dropdown.item
                                    type="button"
                                    :icon="Icon::Ban"
                                    x-on:click.prevent="$dispatch('dropdown-close')"
                                >
                                    Cancel
                                </x-dropdown.item>
                            </x-dropdown.group>
                        </x-dropdown>
                    </div>
                </x-spacing>
            @endforeach
        </div>
    @else
        <x-panel.manage.empty
            :icon="Icon::Users"
            heading="No reviewer(s) assigned"
            description="Get started by assigning a user as a reviewer"
        ></x-panel.manage.empty>
    @endif

    <input type="hidden" name="global_reviewers" value="{{ $globalReviewers }}" />
</x-panel>
