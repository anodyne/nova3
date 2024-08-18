@use('Nova\Applications\Enums\ApplicationResult')

<x-modal title="Review application" icon="progress">
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
                            <div class="text-sm/5">After reviewing the application, I vote to deny the applicant</div>
                        </div>
                    </button>
                </div>

                <x-fieldset.field label="Comments" id="comments" name="comments">
                    <x-input.textarea rows="5" wire:model.live.debounce.500ms="form.comments"></x-input.textarea>
                </x-fieldset.field>
            </x-fieldset.field-group>

            <x-fieldset.field-group>
                <x-form.dynamic :admin="true" :form="$applicationReviewForm" :$values>
                    {!! scribble($applicationReviewForm->published_fields ?? ['content' => null])->toHtml() !!}
                </x-form.dynamic>
            </x-fieldset.field-group>
        </x-fieldset>

        @if (filled($form->result))
            <x-fieldset.controls>
                <x-button type="button" wire:click="save" color="primary">Submit</x-button>
            </x-fieldset.controls>
        @endif
    </x-form>
</x-modal>
