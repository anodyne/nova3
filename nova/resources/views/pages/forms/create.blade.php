@extends($meta->template)

@use('Illuminate\Support\Js')
@use('Nova\Forms\Models\Form')

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">Add a new form</x-slot>

            <x-slot name="actions">
                @can('viewAny', Form::class)
                    <x-button :href="route('admin.forms.index')" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form
            :action="route('admin.forms.store')"
            x-data="{
                type: {{ Js::from(old('type')) }},
                name: {{ Js::from(old('name')) }},
                key: {{ Js::from(old('key')) }},
                suggestKey: true,
                collectResponses: {{ Js::from(old('options[collectResponses]', true)) }},
                emailResponses: {{ Js::from(old('options[emailResponses]', false)) }},
            }"
            x-init="$watch('name', value => {
                if (suggestKey) {
                    key = value.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
                }
            })"
        >
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-radio.group>
                        <x-radio.field>
                            <x-fieldset.label for="type_basic">Basic form</x-fieldset.label>
                            <x-fieldset.description>
                                A simple form that users can submit and responses can be viewed from the form page
                            </x-fieldset.description>
                            <x-radio id="type_basic" name="type" value="basic" x-model="type"></x-radio>
                        </x-radio.field>

                        <x-radio.field>
                            <x-fieldset.label for="type_advanced">Advanced form</x-fieldset.label>
                            <x-fieldset.description>
                                A form that requires a custom integration with code (i.e. the character form)
                            </x-fieldset.description>
                            <x-radio id="type_advanced" name="type" value="advanced" x-model="type"></x-radio>
                        </x-radio.field>
                    </x-radio.group>
                </x-fieldset.field-group>

                <x-fieldset.field-group x-show="type" constrained x-cloak>
                    <x-fieldset.field label="Name" id="name" name="name" :error="$errors->first('name')">
                        <x-input.text x-model="name" data-cy="name" />
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Key"
                        description="The form key is a unique identifier for the form. This cannot be changed after the form is created."
                        id="key"
                        name="key"
                        :error="$errors->first('key')"
                    >
                        <x-input.text x-model="key" x-on:change="suggestKey = false" data-cy="key" />
                    </x-fieldset.field>

                    <x-fieldset.field label="Description" id="description" name="description">
                        <x-input.textarea rows="5">
                            {{ old('description') }}
                        </x-input.textarea>
                    </x-fieldset.field>

                    <div class="flex items-center gap-x-2.5">
                        <x-switch
                            name="status"
                            :value="old('status', 'active')"
                            on-value="active"
                            off-value="inactive"
                            id="status"
                        ></x-switch>
                        <x-fieldset.label for="status">Active</x-fieldset.label>
                    </div>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset x-show="type === 'basic'" x-cloak>
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
                                id="options_only_authenticated_users"
                                :value="old('options[onlyAuthenticatedUsers]', false)"
                            ></x-switch>
                        </x-switch.field>
                        <x-switch.field>
                            <x-fieldset.label>Collect responses</x-fieldset.label>
                            <x-fieldset.description>
                                Store responses in the database and make them available from the form viewer
                            </x-fieldset.description>
                            <x-switch
                                x-model="collectResponses"
                                name="options[collectResponses]"
                                id="options_collect_responses"
                            ></x-switch>
                        </x-switch.field>
                        <x-switch.field x-show="collectResponses">
                            <x-fieldset.label>Only allow 1 submission</x-fieldset.label>
                            <x-fieldset.description>Only allow a user to submit the form once</x-fieldset.description>
                            <x-switch
                                name="options[singleSubmission]"
                                id="options_single_submission"
                                :value="old('options[singleSubmission]', false)"
                            ></x-switch>
                        </x-switch.field>
                        <x-fieldset.field
                            name="options[submissionTitleField]"
                            id="options_submissionTitleField"
                            label="Submission title field"
                            x-show="collectResponses"
                        >
                            <x-fieldset.warning-message>
                                You will be able to choose a submission title field after designing and publishing your
                                form
                            </x-fieldset.warning-message>
                        </x-fieldset.field>
                        <x-switch.field>
                            <x-fieldset.label>Email responses</x-fieldset.label>
                            <x-fieldset.description>
                                Email responses directly to specific individuals
                            </x-fieldset.description>
                            <x-switch
                                x-model="emailResponses"
                                name="options[emailResponses]"
                                id="options_email_responses"
                            ></x-switch>
                        </x-switch.field>
                    </x-switch.group>

                    <x-fieldset.field
                        label="Recipients"
                        id="recipients"
                        name="options[emailRecipients]"
                        :error="$errors->first('recipients')"
                        x-show="emailResponses"
                    >
                        <x-input.text :value="old('options[emailRecipients]')" />
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls x-show="type" x-cloak>
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('admin.forms.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
@endsection
