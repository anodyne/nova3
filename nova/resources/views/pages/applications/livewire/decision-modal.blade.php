@use('Nova\Applications\Enums\ApplicationResult')

<x-modal title="Final application decision" icon="progress">
    <x-form action="">
        <x-fieldset>
            <x-fieldset.field-group>
                <div data-slot="control" class="grid grid-cols-2 gap-8">
                    <button
                        type="button"
                        wire:click="$set('form.result', 'accept')"
                        @class([
                            'flex flex-col items-center justify-center space-y-1.5 rounded-lg p-6 ring-2',
                            'bg-success-50 text-success-700 ring-success-200 dark:bg-success-950 dark:text-success-300 dark:ring-success-800' => $form->result === ApplicationResult::Accept,
                            'text-gray-600 ring-gray-200 dark:text-gray-400 dark:ring-gray-700' => $form->result !== ApplicationResult::Accept,
                        ])
                    >
                        <x-icon name="progress-check" size="xl"></x-icon>
                        <div class="flex flex-col gap-y-1">
                            <div
                                @class([
                                    'text-base/7 font-semibold',
                                    'text-success-700 dark:text-success-300' => $form->result === ApplicationResult::Accept,
                                    'text-gray-600 dark:text-gray-400' => $form->result !== ApplicationResult::Accept,
                                ])
                            >
                                Accept
                            </div>
                        </div>
                    </button>
                    <button
                        type="button"
                        wire:click="$set('form.result', 'deny')"
                        @class([
                            'flex flex-col items-center justify-center space-y-1.5 rounded-lg p-6 ring-2',
                            'bg-danger-50 text-danger-700 ring-danger-200 dark:bg-danger-950 dark:text-danger-300 dark:ring-danger-800' => $form->result === ApplicationResult::Deny,
                            'text-gray-600 ring-gray-200 dark:text-gray-400 dark:ring-gray-700' => $form->result !== ApplicationResult::Deny,
                        ])
                    >
                        <x-icon name="progress-x" size="lg"></x-icon>
                        <div class="flex flex-col gap-y-1">
                            <div
                                @class([
                                    'text-base/7 font-semibold',
                                    'text-danger-700 dark:text-danger-300' => $form->result === ApplicationResult::Deny,
                                    'text-gray-600 dark:text-gray-400' => $form->result !== ApplicationResult::Deny,
                                ])
                            >
                                Deny
                            </div>
                        </div>
                    </button>
                </div>

                @if ($form->result === ApplicationResult::Accept)
                    <x-fieldset.field
                        label="Position(s)"
                        description="Verify the position(s) this character will be assigned upon activation."
                        id="position"
                        name="position"
                    >
                        <div data-slot="control">
                            <livewire:characters-manage-positions
                                :character="$application->character"
                                @positions-updated="$set('form.positions', $event.detail.positions)"
                            ></livewire:characters-manage-positions>
                        </div>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Rank"
                        description="Verify the rank the character will be assigned upon activation."
                        id="rank"
                        name="rank"
                    >
                        <livewire:rank-items-dropdown
                            :rank="old('rank_id', $application->character->rank_id)"
                            @rank-item-selected="$set('form.rankId', $event.detail.rank)"
                        ></livewire:rank-items-dropdown>
                    </x-fieldset.field>
                @endif

                <x-fieldset.field
                    label="Message"
                    description="This is the message that will be emailed to the applicant notifying them of your decision."
                    id="message"
                    name="message"
                >
                    <x-input.textarea rows="5" wire:model.live.debounce.500ms="form.message"></x-input.textarea>
                </x-fieldset.field>
            </x-fieldset.field-group>
        </x-fieldset>

        <x-fieldset.controls>
            <x-button type="button" wire:click="save" color="primary">Submit</x-button>
            <x-button type="button" wire:click="dismiss">Cancel</x-button>
        </x-fieldset.controls>
    </x-form>
</x-modal>
