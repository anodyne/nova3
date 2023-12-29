@extends($meta->template)

@section('content')
    <x-container.narrow>
        <x-page-header>
            <x-slot name="heading">Add a new user</x-slot>

            <x-slot name="actions">
                <x-button :href="route('users.index')" plain>&larr; Back</x-button>
            </x-slot>
        </x-page-header>

        <div
            x-data="{
                pronouns: '{{ old('pronouns.value', 'none') }}',
                pronounSubject: '{{ old('pronouns.subject', '') }}',
                pronounObject: '{{ old('pronouns.object', '') }}',
                pronounPossessive: '{{ old('pronouns.possessive', '') }}',
            }"
            x-init="
                $watch('pronouns', (value, oldValue) => {
                    if (value !== oldValue) {
                        pronounSubject = ''
                        pronounObject = ''
                        pronounPossessive = ''
                    }
                })
            "
        >
            <x-form :action="route('users.store')">
                <x-fieldset>
                    <x-fieldset.field-group class="w-full max-w-md">
                        <x-input.group
                            label="Name"
                            for="name"
                            :error="$errors->first('name')"
                            help="For privacy reasons, consider using a nickname rather than a user’s real name."
                        >
                            <x-input.text id="name" name="name" :value="old('name')" data-cy="name" />
                        </x-input.group>

                        <x-input.group label="Email address" for="email" :error="$errors->first('email')">
                            <x-input.email id="email" name="email" :value="old('email')" data-cy="email" />
                        </x-input.group>

                        <x-input.group label="Password">
                            <x-text>
                                After the account is created, a password will be generated and emailed to the user.
                            </x-text>
                        </x-input.group>

                        <x-input.group label="Pronouns" for="pronouns" :error="$errors->first('pronouns.value')">
                            <x-input.select name="pronouns[value]" id="pronouns" class="w-auto" x-model="pronouns">
                                <option value="none">Prefer not to share</option>
                                <option value="male">He/Him/His</option>
                                <option value="female">She/Her/Hers</option>
                                <option value="neutral">They/Them/Theirs</option>
                                <option value="neo">Ze/Zir/Zirs</option>
                                <option value="other">Other pronouns not listed (please specify)</option>
                            </x-input.select>
                        </x-input.group>

                        <div x-show="pronouns === 'other'" class="space-y-6" x-cloak>
                            <x-input.group
                                label="What is your subject pronoun?"
                                for="pronouns-subject"
                                :error="$errors->first('pronouns.subject')"
                            >
                                <x-input.text
                                    id="pronouns-subject"
                                    name="pronouns[subject]"
                                    x-model="pronounSubject"
                                    placeholder="He, she, they, ze, etc."
                                />
                            </x-input.group>

                            <x-input.group
                                label="What is your object pronoun?"
                                for="pronouns-object"
                                :error="$errors->first('pronouns.object')"
                            >
                                <x-input.text
                                    id="pronouns-object"
                                    name="pronouns[object]"
                                    x-model="pronounObject"
                                    placeholder="Him, her, them, zir, etc."
                                />
                            </x-input.group>

                            <x-input.group
                                label="What is your possessive pronoun?"
                                for="pronouns-possessive"
                                :error="$errors->first('pronouns.possessive')"
                            >
                                <x-input.text
                                    id="pronouns-possessive"
                                    name="pronouns[possessive]"
                                    x-model="pronounPossessive"
                                    placeholder="His, hers, theirs, zirs, etc."
                                />
                            </x-input.group>
                        </div>

                        <livewire:media-upload-avatar />
                    </x-fieldset.field-group>
                </x-fieldset>

                <x-fieldset>
                    <x-panel well>
                        <x-container width="sm" height="sm">
                            <x-fieldset.legend>Characters assigned to this user</x-fieldset.legend>
                            <x-fieldset.description>
                                Users can be assigned as many characters as you want.
                            </x-fieldset.description>
                        </x-container>

                        <x-container height="2xs" width="2xs">
                            <livewire:users-manage-characters />
                        </x-container>
                    </x-panel>
                </x-fieldset>

                <x-fieldset>
                    <x-panel well>
                        <x-container width="sm" height="sm">
                            <x-fieldset.legend>Roles assigned to this user</x-fieldset.legend>
                            <x-fieldset.description>
                                Roles control what users can do inside of Nova. You can assign as many roles as needed
                                to users.
                            </x-fieldset.description>
                        </x-container>

                        <x-container height="2xs" width="2xs">
                            <livewire:users-manage-roles />
                        </x-container>
                    </x-panel>
                </x-fieldset>

                <x-fieldset>
                    <div class="flex gap-x-2 lg:flex-row-reverse">
                        <x-button type="submit" color="primary">Add</x-button>
                        <x-button :href="route('users.index')" plain>Cancel</x-button>
                    </div>
                </x-fieldset>
            </x-form>
        </div>
    </x-container.narrow>
@endsection
