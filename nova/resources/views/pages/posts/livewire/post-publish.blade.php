@use('Nova\Stories\Enums\PositionDirection')

<x-modal.slide-over title="Publish post" :icon="Tabler::ProgressCheck">
    <x-tab.group>
        <x-slot name="tabs">
            <x-tab name="participants">
                <div class="flex items-center gap-x-1.5">
                    <x-icon :name="Tabler::UserScan" size="sm" />
                    Review participants
                </div>
            </x-tab>

            <x-tab name="position">
                <div class="flex items-center gap-x-1.5">
                    <x-icon :name="Tabler::TimelineEvent" size="sm" />
                    Set post position
                </div>
            </x-tab>
        </x-slot>

        <x-tab.panel name="position">
            @if ($shouldShowPositionPanel)
                <x-radio.group wire:model.live="direction" variant="segmented">
                    <x-radio value="after" label="Custom position">
                        <x-slot name="icon">
                            <x-icon :name="Tabler::ArrowsSort" size="sm" />
                        </x-slot>
                    </x-radio>
                    <x-radio value="start" label="Start of the story">
                        <x-slot name="icon">
                            <x-icon :name="Tabler::ArrowBarToUp" size="sm" />
                        </x-slot>
                    </x-radio>
                    <x-radio value="end" label="End of the story">
                        <x-slot name="icon">
                            <x-icon :name="Tabler::ArrowBarToDown" size="sm" />
                        </x-slot>
                    </x-radio>
                </x-radio.group>

                @if ($direction === PositionDirection::Start)
                    <x-callout.primary heading="Move to start" :icon="Tabler::ArrowBarToUp" class="mt-4">
                        Your post will appear as the first post in the story.
                    </x-callout.primary>
                @endif

                @if ($direction === PositionDirection::End)
                    <x-callout.primary heading="Move to end" :icon="Tabler::ArrowBarToDown" class="mt-4">
                        Your post will appear as the last post in the story.
                    </x-callout.primary>
                @endif

                @if ($direction === PositionDirection::After)
                    <div class="mt-4 space-y-4">
                        <x-panel.manage.search :$search placeholder="Find a post in the current story">
                            @if ($searchResults->count() === 0)
                                <x-empty variant="compact">
                                    <x-icon :name="Tabler::Book2" />
                                    <x-empty.heading>No posts found</x-empty.heading>
                                </x-empty>
                            @else
                                <x-dropdown.group>
                                    @foreach ($searchResults as $searchResult)
                                        <x-panel.manage.result-item
                                            :value="$searchResult->id"
                                            :text="$searchResult->title"
                                        />
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

                                <x-field>
                                    <x-label>Move this post</x-label>

                                    <x-radio.group wire:model.live="direction" variant="segmented">
                                        <x-radio :value="PositionDirection::Before->value" label="Before this post" />
                                        <x-radio :value="PositionDirection::After->value" label="After this post" />
                                    </x-radio.group>
                                </x-field>
                            </div>
                        @endif
                    </div>
                @endif
            @else
                <x-callout.primary :icon="Tabler::TimelineEvent" icon:size="md">
                    This is the first post in the story
                </x-callout.primary>
            @endif
        </x-tab.panel>

        <x-tab.panel name="participants" class="space-y-6">
            @if ($shouldShowParticipantsPanel)
                <x-fieldset>
                    <x-fieldset.heading :icon="Tabler::UserScan" heading="Review participants">
                        <x-description>
                            You can review players who participated in writing this post to ensure that the proper
                            authors are credited.
                        </x-description>
                    </x-fieldset.heading>

                    <x-fieldset.group>
                        <x-callout.warning heading="Post author changes are immediate" :icon="Tabler::AlertTriangle">
                            Be aware that any changes made to post participants on this screen are immediate and cannot
                            be cancelled or reversed. If you remove a participant from the post in error, you will need
                            to manually re-add them before publishing.
                        </x-callout.warning>
                    </x-fieldset.group>

                    <x-fieldset.group>
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
                                                        <x-button
                                                            type="button"
                                                            variant="subtle"
                                                            inset="right"
                                                            square
                                                            data-danger
                                                        >
                                                            <x-icon :name="Tabler::Trash" size="md" />
                                                        </x-button>
                                                    </x-slot>

                                                    <x-dropdown.group>
                                                        <x-dropdown.text>
                                                            Are you sure you want to remove
                                                            <strong>
                                                                {{ $participatingUser->name }}
                                                            </strong>
                                                            and any characters they’re marked as writing as authors of
                                                            this post?
                                                        </x-dropdown.text>
                                                    </x-dropdown.group>
                                                    <x-dropdown.group>
                                                        <x-dropdown.item
                                                            type="button"
                                                            :icon="Tabler::Trash"
                                                            wire:click="removeParticipant({{ $participatingUser }})"
                                                            variant="danger"
                                                        >
                                                            Remove
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
                                </div>
                            </x-panel>

                            @if ($hasNonParticipants)
                                <x-panel.footer class="flex items-center">
                                    <x-dropdown placement="bottom start">
                                        <x-slot name="trigger">
                                            <x-button
                                                type="button"
                                                variant="subtle"
                                                inset="left top bottom"
                                                data-danger
                                            >
                                                <x-icon :name="Tabler::CircleMinus" size="sm" />
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
                                                :icon="Tabler::CircleMinus"
                                                wire:click="removeAllNonParticipants"
                                                variant="danger"
                                            >
                                                Remove all
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
                                </x-panel.footer>
                            @endif
                        </x-panel>
                    </x-fieldset.group>
                </x-fieldset>
            @else
                <x-callout.primary :icon="Tabler::UserScan" icon:size="md">
                    No participants to review
                </x-callout.primary>
            @endif
        </x-tab.panel>
    </x-tab.group>

    <x-slot name="footer">
        <x-button type="button" wire:click="publish" variant="primary">Publish</x-button>
        <x-button type="button" wire:click="dismiss" variant="ghost">Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
