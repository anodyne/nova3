<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                <x-button :href="route('admin.users.index')" plain>&larr; Back</x-button>
            </x-slot>
        </x-page-header>

        <div
            x-data="{
                pronouns: '{{ old('pronouns.value', 'none') }}',
                pronounSubject: '{{ old('pronouns.subject', '') }}',
                pronounObject: '{{ old('pronouns.object', '') }}',
                ...tabsList(
                    '{{ $errors->getBag('default')->has('user.*') ? 'bio' : 'info' }}',
                ),
            }"
            x-init="
                $watch('pronouns', (value, oldValue) => {
                    if (value !== oldValue) {
                        pronounSubject = ''
                        pronounObject = ''
                    }
                })
            "
        >
            <x-form :action="route('admin.users.store')">
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
                                    <option value="male">He/Him</option>
                                    <option value="female">She/Her</option>
                                    <option value="neutral">They/Them</option>
                                    <option value="neo">Ze/Zir</option>
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
                            </div>

                            <livewire:media-upload-avatar />
                        </x-fieldset.field-group>
                    </x-fieldset>

                    <x-fieldset>
                        <x-panel variant="well">
                            <x-panel.header
                                title="Characters assigned to this user"
                                description="Users can be assigned as many characters as you want"
                            ></x-panel.header>

                            <livewire:users-manage-characters />
                        </x-panel>
                    </x-fieldset>

                    <x-fieldset>
                        <x-panel variant="well">
                            <x-panel.header
                                title="Roles assigned to this user"
                                description="Roles control what users can do inside of Nova. You can assign as many roles as needed to users"
                            ></x-panel.header>

                            <livewire:users-manage-roles />
                        </x-panel>
                    </x-fieldset>
                </div>

                <div class="w-full max-w-md" x-show="isTab('bio')">
                    <livewire:dynamic-form :form="$form" :admin="true" />
                </div>

                <x-fieldset.controls>
                    <x-button type="submit" color="primary">Add</x-button>
                    <x-button :href="route('admin.users.index')" plain>Cancel</x-button>
                </x-fieldset.controls>
            </x-form>
        </div>
    </x-spacing>
</x-admin-layout>
