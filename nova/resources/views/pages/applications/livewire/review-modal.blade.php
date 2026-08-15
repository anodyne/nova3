@use('Nova\Applications\Enums\ApplicationResult')

<x-modal :size-class="$this->sizeClass()" title="Review application" :icon="Tabler::Progress">
    <x-form action="">
        <x-fieldset>
            <x-fieldset.group>
                <div class="grid grid-cols-2 gap-8">
                    <button
                        type="button"
                        wire:click="$set('form.result', 'accept')"
                        @class([
                            'flex flex-col items-center justify-center space-y-1.5 rounded-lg p-6 ring-2',
                            'bg-success-50 text-success-700 ring-success-200 dark:bg-success-950 dark:text-success-300 dark:ring-success-800' => $form->result === ApplicationResult::Accept,
                            'text-gray-600 ring-gray-200 dark:text-gray-400 dark:ring-gray-700' => $form->result !== ApplicationResult::Accept,
                        ])
                    >
                        <x-icon :name="Tabler::ProgressCheck" size="xl" />
                        <div class="flex flex-col gap-1">
                            <div
                                @class([
                                    'text-base/7 font-semibold',
                                    'text-success-700 dark:text-success-300' => $form->result === ApplicationResult::Accept,
                                    'text-gray-600 dark:text-gray-400' => $form->result !== ApplicationResult::Accept,
                                ])
                            >
                                Accept
                            </div>
                            <div class="text-sm/5">After reviewing the application, I vote to accept the applicant</div>
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
                        <x-icon :name="Tabler::ProgressX" size="xl" />
                        <div class="flex flex-col gap-1">
                            <div
                                @class([
                                    'text-base/7 font-semibold',
                                    'text-danger-700 dark:text-danger-300' => $form->result === ApplicationResult::Deny,
                                    'text-gray-600 dark:text-gray-400' => $form->result !== ApplicationResult::Deny,
                                ])
                            >
                                Deny
                            </div>
                            <div class="text-sm/5">After reviewing the application, I vote to deny the applicant</div>
                        </div>
                    </button>
                </div>

                <x-textarea label="Comments" rows="5" wire:model.live.debounce="form.comments"></x-textarea>
            </x-fieldset.group>

            <x-fieldset.group>
                <x-form.dynamic :admin="true" :form="$applicationReviewForm" :$values>
                    {!! $applicationReviewForm->rendered_block_content !!}
                </x-form.dynamic>
            </x-fieldset.group>
        </x-fieldset>
    </x-form>

    @if (filled($form->result))
        <x-slot name="footer">
            <x-button type="button" wire:click="save" variant="primary">Submit</x-button>
            <x-button type="button" wire:click="close" variant="ghost" :loading="false">Cancel</x-button>
        </x-slot>
    @endif
</x-modal>
