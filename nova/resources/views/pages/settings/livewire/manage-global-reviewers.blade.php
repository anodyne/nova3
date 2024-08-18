<div>
    <x-panel.manage>
        <x-panel.manage.search
            :search="$search"
            placeholder="Find a user to add as a reviewer (type * to see all users)"
        >
            <x-dropdown.group>
                @forelse ($searchResults as $user)
                    <x-panel.manage.result-item :value="$user->id" :text="$user->name"></x-panel.manage.result-item>
                @empty
                    <x-empty-state.small icon="users" title="No reviewer(s) found"></x-empty-state.small>
                @endforelse
            </x-dropdown.group>
        </x-panel.manage.search>

        @if ($reviewers->count() > 0)
            <div
                class="divide-y divide-gray-200 rounded-b-lg border-t border-gray-200 dark:divide-gray-800 dark:border-gray-800"
            >
                @foreach ($reviewers as $user)
                    <div
                        class="flex items-center justify-between bg-white px-6 py-3 last:rounded-b-lg dark:bg-gray-900"
                        wire:key="row-{{ $user->id }}"
                    >
                        <div>
                            <x-avatar.user :user="$user"></x-avatar.user>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <x-dropdown placement="bottom-end">
                                <x-slot name="trigger" color="neutral-danger">
                                    <x-icon name="trash" size="sm"></x-icon>
                                </x-slot>

                                <x-dropdown.group>
                                    <x-dropdown.text>
                                        Are you sure you want to unassign
                                        <strong class="font-semibold text-gray-700 dark:text-gray-200">
                                            {{ $user->name }}
                                        </strong>
                                        as a global reviewer?
                                    </x-dropdown.text>
                                </x-dropdown.group>
                                <x-dropdown.group>
                                    <x-dropdown.item-danger
                                        type="button"
                                        icon="trash"
                                        wire:click="remove({{ $user->id }})"
                                    >
                                        Unassign
                                    </x-dropdown.item-danger>
                                    <x-dropdown.item
                                        type="button"
                                        icon="prohibited"
                                        x-on:click.prevent="$dispatch('dropdown-close')"
                                    >
                                        Cancel
                                    </x-dropdown.item>
                                </x-dropdown.group>
                            </x-dropdown>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <x-panel.manage.empty
                icon="users"
                heading="No reviewer(s) assigned"
                description="Get started by assigning a user as a reviewer"
            ></x-panel.manage.empty>
        @endif
    </x-panel.manage>

    <input type="hidden" name="global_reviewers" value="{{ $globalReviewers }}" />
</div>
