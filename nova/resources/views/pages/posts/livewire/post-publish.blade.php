@use('Nova\Stories\Enums\PositionDirection')

<x-modal.slide-over title="Publish post" :icon="Icon::ProgressCheck">
    <flux:tab.group>
        <flux:tabs>
            <flux:tab name="participants">
                <div class="flex items-center gap-x-1.5">
                    <x-icon :name="Icon::UserScan" size="sm"></x-icon>
                    Review participants
                </div>
            </flux:tab>

            <flux:tab name="position">
                <div class="flex items-center gap-x-1.5">
                    <x-icon :name="Icon::Timeline" size="sm"></x-icon>
                    Set post position
                </div>
            </flux:tab>
        </flux:tabs>

        <flux:tab.panel name="position">
            @if ($shouldShowPositionPanel)
                <flux:tab.group>
                    <flux:tabs variant="pills">
                        <flux:tab name="custom" wire:click="$set('direction', 'after')">
                            <div class="flex items-center gap-x-1.5">
                                <x-icon :name="Icon::ArrowsSort" size="sm"></x-icon>
                                Custom position
                            </div>
                        </flux:tab>
                        <flux:tab name="start" wire:click="$set('direction', 'start')">
                            <div class="flex items-center gap-x-1.5">
                                <x-icon :name="Icon::ArrowVerticalStart" size="sm"></x-icon>
                                Start of the story
                            </div>
                        </flux:tab>
                        <flux:tab name="end" wire:click="$set('direction', 'end')">
                            <div class="flex items-center gap-x-1.5">
                                <x-icon :name="Icon::ArrowVerticalEnd" size="sm"></x-icon>
                                End of the story
                            </div>
                        </flux:tab>
                    </flux:tabs>

                    <flux:tab.panel name="start">
                        <x-panel.primary
                            title="Move to start"
                            description="Your post will appear as the first post in the story."
                            :icon="Icon::ArrowVerticalStart"
                        ></x-panel.primary>
                    </flux:tab.panel>

                    <flux:tab.panel name="end">
                        <x-panel.primary
                            title="Move to end"
                            description="Your post will appear as the last post in the story."
                            :icon="Icon::ArrowVerticalEnd"
                        ></x-panel.primary>
                    </flux:tab.panel>

                    <flux:tab.panel name="custom" class="space-y-6">
                        <x-panel.manage.search :$search placeholder="Find a post in the current story">
                            @if ($searchResults->count() === 0)
                                <x-empty-state.small
                                    :icon="Icon::BookClosed"
                                    title="No post(s) found"
                                ></x-empty-state.small>
                            @else
                                <x-dropdown.group>
                                    @foreach ($searchResults as $searchResult)
                                        <x-panel.manage.result-item
                                            :value="$searchResult->id"
                                            :text="$searchResult->title"
                                        ></x-panel.manage.result-item>
                                    @endforeach
                                </x-dropdown.group>
                            @endif
                        </x-panel.manage.search>

                        @if ($neighbor)
                            <div class="space-y-3">
                                <div>
                                    <x-h2>{{ $neighbor?->title }}</x-h2>
                                    <x-text>
                                        <em>
                                            {{ $neighbor?->location_day_time }}
                                        </em>
                                    </x-text>
                                </div>

                                <x-text size="lg">
                                    {{ $neighbor?->authors_string }}
                                </x-text>

                                <x-fieldset.field id="move" name="move" label="Move this post">
                                    <flux:radio.group
                                        wire:model.live="direction"
                                        variant="segmented"
                                        data-slot="control"
                                    >
                                        <flux:radio
                                            :value="PositionDirection::Before->value"
                                            label="Before this post"
                                        />
                                        <flux:radio :value="PositionDirection::After->value" label="After this post" />
                                    </flux:radio.group>
                                </x-fieldset.field>
                            </div>
                        @endif
                    </flux:tab.panel>
                </flux:tab.group>
            @else
                <x-panel.primary title="This is the first post in the story" :icon="Icon::Timeline"></x-panel.primary>
            @endif
        </flux:tab.panel>

        <flux:tab.panel name="participants" class="space-y-6">
            @if ($shouldShowParticipantsPanel)
                <x-fieldset>
                    <x-fieldset.heading>
                        <x-icon :name="Icon::UserScan"></x-icon>
                        <x-fieldset.legend>Review participants</x-fieldset.legend>
                        <x-fieldset.description>
                            You can review players who participated in writing this post to ensure that the proper
                            authors are credited.
                        </x-fieldset.description>
                    </x-fieldset.heading>

                    <x-fieldset.field-group>
                        <x-panel.warning
                            title="Post author changes are immediate"
                            :icon="Icon::Warning"
                            description="Be aware that any changes made to post participants on this screen are immediate and cannot be cancelled or reversed. If you remove a participant from the post in error, you will need to manually re-add them before publishing."
                        ></x-panel.warning>
                    </x-fieldset.field-group>

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
                                                        <span class="font-medium">
                                                            {{ $participatingUser->name }}
                                                        </span>
                                                    </div>
                                                    <div class="ml-5">
                                                        @foreach ($post->characterAuthors()->wherePivot('user_id', $participatingUser->id)->get() as $character)
                                                            <div class="text-sm">
                                                                {{ $character->displayName }}
                                                            </div>
                                                        @endforeach

                                                        @foreach ($post->userAuthors()->wherePivot('user_id', $participatingUser->id)->get() as $user)
                                                            <div class="text-sm italic">
                                                                {{ $user->pivot->as }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-x-4">
                                                <div class="text-sm/6 tabular-nums">
                                                    {{ Number::format($participatingUser->pivot->word_count) }}
                                                    {{ str('word')->plural($participatingUser->pivot->word_count) }}
                                                </div>

                                                <x-dropdown placement="bottom end">
                                                    <x-slot name="trigger">
                                                        <x-button type="button" color="neutral-danger" size="none" text>
                                                            <x-icon :name="Icon::MinusCircle" size="md"></x-icon>
                                                        </x-button>
                                                    </x-slot>

                                                    <x-dropdown.group>
                                                        <x-dropdown.text>
                                                            Are you sure you want to remove
                                                            <strong class="font-semibold">
                                                                {{ $participatingUser->name }}
                                                            </strong>
                                                            and any characters they’re marked as writing as authors of
                                                            this post?
                                                        </x-dropdown.text>
                                                    </x-dropdown.group>
                                                    <x-dropdown.group>
                                                        <x-dropdown.item
                                                            type="button"
                                                            :icon="Icon::MinusCircle"
                                                            wire:click="removeParticipant({{ $participatingUser }})"
                                                            variant="danger"
                                                        >
                                                            Remove
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
                            </x-panel>

                            @if ($hasNonParticipants)
                                <x-panel.footer class="flex items-center">
                                    <x-dropdown placement="bottom start">
                                        <x-slot name="trigger">
                                            <x-button type="button" color="neutral-danger" size="none" text>
                                                <x-icon :name="Icon::MinusCircle" size="sm"></x-icon>
                                                <span>Remove all non-participating users</span>
                                            </x-button>
                                        </x-slot>

                                        <x-dropdown.group>
                                            <x-dropdown.text>
                                                Are you sure you want to remove all users who did not participate in
                                                writing this post and their characters?
                                            </x-dropdown.text>
                                        </x-dropdown.group>
                                        <x-dropdown.group>
                                            <x-dropdown.item
                                                type="button"
                                                :icon="Icon::MinusCircle"
                                                wire:click="removeAllNonParticipants"
                                                variant="danger"
                                            >
                                                Remove all
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
                                </x-panel.footer>
                            @endif
                        </x-panel>
                    </x-fieldset.field-group>
                </x-fieldset>
            @else
                <x-panel.primary title="No participants to review" icon="user-scan"></x-panel.primary>
            @endif
        </flux:tab.panel>
    </flux:tab.group>

    <x-slot name="footer">
        <x-button type="button" wire:click="publish" color="primary">Publish</x-button>
        <x-button type="button" wire:click="dismiss" plain>Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
