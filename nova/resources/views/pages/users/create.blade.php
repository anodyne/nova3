@extends($meta->template)

@section('content')
    <x-spacing constrained>
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
                ...tabsList(
                    '{{ $errors->getBag('default')->has('user.*') ? 'bio' : 'info' }}',
                ),
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
                @if (filled($form->published_fields))
                    <x-tab.group name="user">
                        <x-tab.heading name="info">
                            <x-icon name="info" size="sm"></x-icon>
                            Basic info
                        </x-tab.heading>
                        <x-tab.heading name="bio">
                            <x-icon name="user-profile" size="sm"></x-icon>
                            Bio
                        </x-tab.heading>
                    </x-tab.group>
                @endif

                <div class="space-y-12" x-show="isTab('info')">
                    <x-fieldset>
                        <x-fieldset.field-group constrained>
                            <x-fieldset.field
                                label="Name"
                                description="For privacy reasons, consider using a nickname rather than a user’s real name."
                                id="name"
                                name="name"
                                :error="$errors->first('name')"
                            >
                                <x-input.text :value="old('name')" data-cy="name" />
                            </x-fieldset.field>

                            <x-fieldset.field
                                label="Email address"
                                id="email"
                                name="email"
                                :error="$errors->first('email')"
                            >
                                <x-input.email :value="old('email')" data-cy="email" />
                            </x-fieldset.field>

                            <x-fieldset.field
                                label="Password"
                                description="After the account is created, a password will be generated and emailed to the user."
                                id="password"
                                name="password"
                            ></x-fieldset.field>

                            <x-fieldset.field
                                label="Pronouns"
                                id="pronouns"
                                name="pronouns[value]"
                                :error="$errors->first('pronouns.value')"
                            >
                                <x-select class="w-auto" x-model="pronouns">
                                    <option value="none">Prefer not to share</option>
                                    <option value="male">He/Him/His</option>
                                    <option value="female">She/Her/Hers</option>
                                    <option value="neutral">They/Them/Theirs</option>
                                    <option value="neo">Ze/Zir/Zirs</option>
                                    <option value="other">Other pronouns not listed (please specify)</option>
                                </x-select>
                            </x-fieldset.field>

                            <div x-show="pronouns === 'other'" class="space-y-6" x-cloak>
                                <x-fieldset.field
                                    label="What is your subject pronoun?"
                                    id="pronouns_subject"
                                    name="pronouns[subject]"
                                    :error="$errors->first('pronouns.subject')"
                                >
                                    <x-input.text x-model="pronounSubject" placeholder="He, she, they, ze, etc." />
                                </x-fieldset.field>

                                <x-fieldset.field
                                    label="What is your object pronoun?"
                                    id="pronouns_object"
                                    name="pronouns[object]"
                                    :error="$errors->first('pronouns.object')"
                                >
                                    <x-input.text x-model="pronounObject" placeholder="Him, her, them, zir, etc." />
                                </x-fieldset.field>

                                <x-fieldset.field
                                    label="What is your possessive pronoun?"
                                    id="pronouns_possessive"
                                    name="pronouns[possessive]"
                                    :error="$errors->first('pronouns.possessive')"
                                >
                                    <x-input.text
                                        x-model="pronounPossessive"
                                        placeholder="His, hers, theirs, zirs, etc."
                                    />
                                </x-fieldset.field>
                            </div>

                            <livewire:media-upload-avatar />
                        </x-fieldset.field-group>
                    </x-fieldset>

                    <x-fieldset>
                        <x-panel well>
                            <x-spacing size="sm">
                                <x-fieldset.legend>Characters assigned to this user</x-fieldset.legend>
                                <x-fieldset.description>
                                    Users can be assigned as many characters as you want.
                                </x-fieldset.description>
                            </x-spacing>

                            <x-spacing size="2xs">
                                <livewire:users-manage-characters />
                            </x-spacing>
                        </x-panel>
                    </x-fieldset>

                    <x-fieldset>
                        <x-panel well>
                            <x-spacing size="sm">
                                <x-fieldset.legend>Roles assigned to this user</x-fieldset.legend>
                                <x-fieldset.description>
                                    Roles control what users can do inside of Nova. You can assign as many roles as
                                    needed to users.
                                </x-fieldset.description>
                            </x-spacing>

                            <x-spacing size="2xs">
                                <livewire:users-manage-roles />
                            </x-spacing>
                        </x-panel>
                    </x-fieldset>
                </div>

                <div class="w-full max-w-md" x-show="isTab('bio')">
                    <livewire:dynamic-form :form="$form" :admin="true" />
                </div>

                <x-fieldset.controls>
                    <x-button type="submit" color="primary">Add</x-button>
                    <x-button :href="route('users.index')" plain>Cancel</x-button>
                </x-fieldset.controls>
            </x-form>
        </div>
    </x-spacing>
@endsection
