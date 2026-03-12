@use('Nova\Foundation\Enums\BasicStatus')
@use('Nova\Forms\Enums\FormType')
@use('Nova\Forms\Models\Form')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            <x-slot name="actions">
                @can('viewAny', $form::class)
                    <x-button :href="route('admin.forms.index')" variant="ghost">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                @endcan

                @can('design', $form)
                    <x-button :href="route('admin.forms.design', $form)">
                        <x-icon :name="Tabler::Tools" size="sm" />
                        Design
                    </x-button>
                @endcan
            </x-slot>
        </x-page-heading>

        <x-form
            :action="route('admin.forms.update', $form)"
            method="PUT"
            x-data="{
                emailResponses: {{ Js::from(old('options[emailResponses]', $form->options?->emailResponses ?? false)) }},
                collectResponses: {{ Js::from(old('options[collectResponses]', $form->options?->collectResponses ?? false)) }},
            }"
        >
            <x-fieldset>
                <x-fieldset.group constrained>
                    <x-input label="Name" name="name" :value="old('name', $form->name)" />

                    <x-input label="Key" name="key" :value="$form->key" readonly variant="filled" />

                    <x-field>
                        <x-label>Type</x-label>
                        <div>
                            <x-badge :color="$form->type->getColor()" size="md">
                                {{ $form->type->getLabel() }}
                            </x-badge>
                            <input type="hidden" name="type" value="{{ $form->type }}" />
                        </div>
                    </x-field>

                    <x-textarea label="Description" name="description" rows="5">
                        {{ old('description', $form->description) }}
                    </x-textarea>

                    <x-switch
                        label="Active"
                        name="status"
                        :checked="old('status', $form->status === BasicStatus::Active)"
                        align="left"
                    />
                </x-fieldset.group>
            </x-fieldset>

            @if ($form->type === FormType::Basic)
                <x-fieldset>
                    <x-fieldset.heading :icon="Tabler::Settings" heading="Form options">
                        <x-description>
                            When displayed on the public site, only in character posts will be visible. Out of character
                            posts will still be visible in the admin panel.
                        </x-description>
                    </x-fieldset.heading>

                    <x-fieldset.group constrained>
                        <x-switch
                            label="Only authenticated users"
                            description="Only allow users who are signed-in to submit this form"
                            name="options[onlyAuthenticatedUsers]"
                            :checked="old('options[onlyAuthenticatedUsers]', $form->options?->onlyAuthenticatedUsers ?? false)"
                        />

                        <x-switch
                            label="Collect responses"
                            description="Store responses in the database and make them available from the form viewer"
                            x-model="collectResponses"
                            name="options[collectResponses]"
                        />

                        <div class="space-y-8" x-show="collectResponses" x-collapse x-cloak>
                            <x-switch
                                label="Only allow 1 submission"
                                description="Only allow a user to submit the form once"
                                name="options[singleSubmission]"
                                :checked="old('options[singleSubmission]', $form->options?->singleSubmission ?? false)"
                            />

                            <x-select
                                label="Submission title field"
                                description="Choose the field that will be used in the form submissions list as the title field"
                                name="options[submissionTitleField]"
                            >
                                <option value="">Select a field</option>
                                @foreach ($fields as $uid => $label)
                                    <option
                                        value="{{ $uid }}"
                                        @selected($form->options?->submissionTitleField === $uid)
                                    >
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>

                        <x-switch
                            label="Email responses"
                            description="Email responses directly to specific individuals"
                            x-model="emailResponses"
                            name="options[emailResponses]"
                        />

                        <div class="space-y-8" x-show="emailResponses" x-collapse x-cloak>
                            <x-input
                                label="Recipients"
                                name="options[emailRecipients]"
                                :value="old('options[emailRecipients]', $form->options?->emailRecipients)"
                            />
                        </div>
                    </x-fieldset.group>
                </x-fieldset>
            @endif

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
                <x-button :href="route('admin.forms.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
