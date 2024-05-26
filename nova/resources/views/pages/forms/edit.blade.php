@extends($meta->template)

@use('Illuminate\Support\Js')
@use('Nova\Forms\Enums\FormType')
@use('Nova\Forms\Models\Form')

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">Edit form</x-slot>

            <x-slot name="actions">
                @can('viewAny', $form::class)
                    <x-button :href="route('forms.index')" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form
            :action="route('forms.update', $form)"
            method="PUT"
            x-data="{
                emailResponses: {{ Js::from(old('options[emailResponses]', $form->options->emailResponses)) }},
                collectResponses: {{ Js::from(old('options[collectResponses]', $form->options->collectResponses)) }},
            }"
        >
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Name" id="name" name="name" :error="$errors->first('name')">
                        <x-input.text :value="old('name', $form->name)" data-cy="name" />
                    </x-fieldset.field>

                    <x-fieldset.field label="Key" id="key" name="key">
                        <x-text>{{ $form->key }}</x-text>
                        <input type="hidden" name="key" value="{{ $form->key }}" />
                    </x-fieldset.field>

                    <x-fieldset.field label="Type" id="type" name="type">
                        <x-text>{{ $form->type->getLabel() }}</x-text>
                        <input type="hidden" name="type" value="{{ $form->type }}" />
                    </x-fieldset.field>

                    <x-fieldset.field label="Description" id="description" name="description">
                        <x-input.textarea rows="5">
                            {{ old('description', $form->description) }}
                        </x-input.textarea>
                    </x-fieldset.field>

                    <div class="flex items-center gap-x-2.5">
                        <x-switch
                            name="status"
                            :value="old('status', $form->status->value)"
                            on-value="active"
                            off-value="inactive"
                            id="status"
                        ></x-switch>
                        <x-fieldset.label for="status">Active</x-fieldset.label>
                    </div>
                </x-fieldset.field-group>
            </x-fieldset>

            @if ($form->type === FormType::Basic)
                <x-fieldset>
                    <x-fieldset.heading>
                        <x-icon name="settings"></x-icon>
                        <x-fieldset.legend>Form options</x-fieldset.legend>
                        <x-fieldset.description>
                            When displayed on the public site, only in character posts will be visible. Out of character
                            posts will still be visible in the admin panel.
                        </x-fieldset.description>
                    </x-fieldset.heading>

                    <x-fieldset.field-group constrained>
                        <x-switch.group>
                            <x-switch.field>
                                <x-fieldset.label>Only authenticated users</x-fieldset.label>
                                <x-fieldset.description>
                                    Only allow users who are signed-in to submit this form
                                </x-fieldset.description>
                                <x-switch
                                    name="options[onlyAuthenticatedUsers]"
                                    :value="old('options[onlyAuthenticatedUsers]', $form->options->onlyAuthenticatedUsers)"
                                ></x-switch>
                            </x-switch.field>
                            <x-switch.field>
                                <x-fieldset.label>Collect responses</x-fieldset.label>
                                <x-fieldset.description>
                                    Store responses in the database and make them available from the form viewer
                                </x-fieldset.description>
                                <x-switch x-model="collectResponses" name="options[collectResponses]"></x-switch>
                            </x-switch.field>
                            <x-switch.field x-show="collectResponses">
                                <x-fieldset.label>Only allow 1 submission</x-fieldset.label>
                                <x-fieldset.description>
                                    Only allow a user to submit the form once
                                </x-fieldset.description>
                                <x-switch
                                    name="options[singleSubmission]"
                                    :value="old('options[singleSubmission]', $form->options->singleSubmission)"
                                ></x-switch>
                            </x-switch.field>
                            <x-switch.field>
                                <x-fieldset.label>Email responses</x-fieldset.label>
                                <x-fieldset.description>
                                    Email responses directly to specific individuals
                                </x-fieldset.description>
                                <x-switch x-model="emailResponses" name="options[emailResponses]"></x-switch>
                            </x-switch.field>
                        </x-switch.group>

                        <x-fieldset.field
                            label="Recipients"
                            id="recipients"
                            name="options[emailRecipients]"
                            :error="$errors->first('recipients')"
                            x-show="emailResponses"
                        >
                            <x-input.text :value="old('options[emailRecipients]', $form->options->emailRecipients)" />
                        </x-fieldset.field>
                    </x-fieldset.field-group>
                </x-fieldset>
            @endif

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
                <x-button :href="route('forms.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
@endsection