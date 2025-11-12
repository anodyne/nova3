@use('Nova\Forms\Models\Form')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            @can('viewAny', Form::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.forms.index')" variant="ghost" inset="right">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-heading>

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
                <x-fieldset.group constrained>
                    <x-radio.group x-model="type" name="type">
                        <x-radio
                            label="Basic form"
                            description="A simple form that users can submit and responses can be viewed from the form page"
                            value="basic"
                        />

                        <x-radio
                            label="Advanced form"
                            description="A form that requires a custom integration with code (i.e. the character form)"
                            value="advanced"
                        />
                    </x-radio.group>
                </x-fieldset.group>

                <x-fieldset.group x-show="type" constrained x-cloak>
                    <x-input label="Name" name="name" x-model="name" />

                    <x-input
                        label="Key"
                        description="The form key is a unique identifier for the form. This cannot be changed after the form is created"
                        x-model="key"
                        x-on:change="suggestKey = false"
                        name="key"
                    />

                    <x-textarea label="Description" name="description" rows="5">
                        {{ old('description') }}
                    </x-textarea>

                    <x-switch label="Active" name="status" :checked="old('status')" align="left" />
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset x-show="type === 'basic'" x-cloak>
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
                        :checked="old('options[onlyAuthenticatedUsers]')"
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
                            :checked="old('options[singleSubmission]')"
                        />

                        <x-field>
                            <x-label>Submission title field</x-label>
                            <x-description>
                                You will be able to choose a submission title field after designing and publishing your
                                form
                            </x-description>
                        </x-field>
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
                            :value="old('options[emailRecipients]')"
                        />
                    </div>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset.controls x-show="type" x-cloak>
                <x-button type="submit" variant="primary">Add</x-button>
                <x-button :href="route('admin.forms.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
