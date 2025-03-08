@use('Nova\Stories\Enums\PositionDirection')

<x-modal.slide-over title="Publish post" icon="progress-check">
    <flux:tab.group>
        <flux:tabs variant="pills">
            @if ($shouldShowParticipantsPanel)
                <flux:tab name="participants">
                    <div class="flex items-center gap-x-1.5">
                        <x-icon name="user-scan" size="sm"></x-icon>
                        Review participants
                    </div>
                </flux:tab>
            @endif

            <flux:tab name="position">
                <div class="flex items-center gap-x-1.5">
                    <x-icon name="timeline" size="sm"></x-icon>
                    Set post position
                </div>
            </flux:tab>
        </flux:tabs>

        <flux:tab.panel name="position">
            <x-panel.primary
                title="Move to start"
                description="Your post will appear as the first post in the story."
                icon="arrow-vertical-start"
            ></x-panel.primary>
        </flux:tab.panel>

        @if ($shouldShowParticipantsPanel)
            <flux:tab.panel name="participants" class="space-y-6">
                <x-fieldset>
                    <x-fieldset.heading>
                        <x-icon name="user-scan"></x-icon>
                        <x-fieldset.legend>Review participants</x-fieldset.legend>
                        <x-fieldset.description>
                            You can review players who participated in writing this post to ensure that the proper
                            authors are credited.
                        </x-fieldset.description>
                    </x-fieldset.heading>

                    <x-fieldset.field-group>
                        <x-panel variant="well">
                            <x-panel>
                                <div class="divide-y divide-gray-950/5 rounded-b-lg dark:divide-white/5">
                                    @foreach ($participatingUsers as $participatingUser)
                                        <x-spacing size="row" class="flex items-center justify-between gap-6">
                                            <div class="flex flex-col space-x-3 sm:flex-row sm:items-center">
                                                <div class="flex flex-col gap-0.5">
                                                    <div class="flex items-center">
                                                        <span
                                                            @class([
                                                                'mr-3 inline-block h-2 w-2 shrink-0 rounded-full',
                                                                'bg-success-500' => in_array($participatingUser->id, $post->participants ?? []),
                                                                'bg-danger-500' => ! in_array($participatingUser->id, $post->participants ?? []),
                                                            ])
                                                        ></span>
                                                        <span class="font-medium">{{ $participatingUser->name }}</span>
                                                    </div>
                                                    <div class="ml-5">
                                                        @foreach ($post->characterAuthors()->wherePivot('user_id', $participatingUser->id)->get() as $character)
                                                            <div class="text-sm">{{ $character->displayName }}</div>
                                                        @endforeach

                                                        @foreach ($post->userAuthors()->wherePivot('user_id', $participatingUser->id)->get() as $user)
                                                            <div class="text-sm italic">{{ $user->pivot->as }}</div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-x-4">
                                                <div class="text-sm/6 tabular-nums">
                                                    {{ Number::format($participatingUser->pivot->word_count) }}
                                                    {{ str('word')->plural($participatingUser->pivot->word_count) }}
                                                </div>

                                                <x-dropdown placement="bottom-end">
                                                    <x-slot name="trigger" color="neutral-danger">
                                                        <x-icon name="remove" size="md"></x-icon>
                                                    </x-slot>

                                                    <x-dropdown.group>
                                                        <x-dropdown.text>
                                                            Are you sure you want to remove
                                                            <strong
                                                                class="font-semibold text-gray-700 dark:text-gray-950/5"
                                                            >
                                                                {{ $participatingUser->name }}
                                                            </strong>
                                                            and any characters they’re marked as writing as authors of
                                                            this post?
                                                        </x-dropdown.text>
                                                    </x-dropdown.group>
                                                    <x-dropdown.group>
                                                        <x-dropdown.item-danger
                                                            type="button"
                                                            icon="remove"
                                                            wire:click="removeParticipant({{ $participatingUser }})"
                                                        >
                                                            Remove
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
                                        </x-spacing>
                                    @endforeach
                                </div>
                            </x-panel>

                            @if ($hasNonParticipants)
                                <x-panel.footer class="flex items-center">
                                    <x-dropdown placement="bottom-start">
                                        <x-slot name="trigger" color="neutral-danger">
                                            <div class="flex items-center gap-2">
                                                <x-icon name="remove" size="sm"></x-icon>
                                                <span>Remove all non-participating users</span>
                                            </div>
                                        </x-slot>

                                        <x-dropdown.group>
                                            <x-dropdown.text>
                                                Are you sure you want to remove all users who did not participate in
                                                writing this post and their characters?
                                            </x-dropdown.text>
                                        </x-dropdown.group>
                                        <x-dropdown.group>
                                            <x-dropdown.item-danger
                                                type="button"
                                                icon="remove"
                                                wire:click="removeAllNonParticipants"
                                            >
                                                Remove all
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
                                </x-panel.footer>
                            @endif
                        </x-panel>
                    </x-fieldset.field-group>
                </x-fieldset>
            </flux:tab.panel>
        @endif
    </flux:tab.group>

    <x-slot name="footer">
        <x-button type="button" wire:click="publish" color="primary">Publish</x-button>
        <x-button type="button" wire:click="close" plain>Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
