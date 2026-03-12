@php
    $errors = $errors->getBag('default');
@endphp

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            <x-slot name="actions">
                <x-button :href="route('admin.users.index')" variant="ghost" inset="right">
                    <span aria-hidden="true">←</span>
                    Back
                </x-button>
            </x-slot>
        </x-page-heading>

        <div
            x-data="{
                pronouns: '{{ old('pronouns.value', 'none') }}',
                pronounSubject: '{{ old('pronouns.subject', '') }}',
                pronounObject: '{{ old('pronouns.object', '') }}',
                ...tabsList(
                    '{{ $errors->has('userBio.*') && ! $errors->hasAny(['name', 'email', 'pronouns']) ? 'bio' : 'info' }}',
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
                    <x-tab.group>
                        <x-slot name="tabs">
                            <x-tab name="info">
                                <x-icon :name="Tabler::InfoCircle" size="sm" />
                                Basic info
                                @if ($errors->hasAny(['email', 'name', 'pronouns']))
                                    <span class="text-danger-500 shrink-0">
                                        <x-icon.micro.alert />
                                    </span>
                                @endif
                            </x-tab>
                            <x-tab name="bio">
                                <x-icon :name="Tabler::UserCircle" size="sm" />
                                Bio
                                @if ($errors->has('userBio.*'))
                                    <span class="text-danger-500 shrink-0">
                                        <x-icon.micro.alert />
                                    </span>
                                @endif
                            </x-tab>
                        </x-slot>
                    </x-tab.group>
                @endif

                <div class="space-y-12" x-show="isTab('info')">
                    <x-fieldset>
                        <x-fieldset.group constrained>
                            <x-input
                                label="Name"
                                description="For privacy reasons, consider using a nickname rather than a user’s real name"
                                name="name"
                                :value="old('name')"
                            />

                            <x-input.email label="Email address" name="email" :value="old('email')" />

                            <x-field>
                                <x-label>Password</x-label>
                                <x-text>
                                    After the account is created, a password will be generated and emailed to the user
                                </x-text>
                            </x-field>

                            <x-select label="Pronouns" name="pronouns[value]" class="w-auto" x-model="pronouns">
                                <option value="none">Prefer not to share</option>
                                <option value="male">He/Him</option>
                                <option value="female">She/Her</option>
                                <option value="neutral">They/Them</option>
                                <option value="other">Other pronouns not listed (please specify)</option>
                            </x-select>

                            <div x-show="pronouns === 'other'" class="space-y-6" x-cloak>
                                <x-input
                                    label="What is your subject pronoun?"
                                    name="pronouns[subject]"
                                    x-model="pronounSubject"
                                    placeholder="He, she, they, ze, etc."
                                />

                                <x-input
                                    label="What is your object pronoun?"
                                    name="pronouns[object]"
                                    x-model="pronounObject"
                                    placeholder="Him, her, them, zir, etc."
                                />
                            </div>

                            <x-field>
                                <x-label>User photo</x-label>
                                <livewire:media-upload-avatar />
                            </x-field>
                        </x-fieldset.group>
                    </x-fieldset>

                    <x-fieldset>
                        <x-fieldset.group constrained>
                            <x-field>
                                <x-label>Role(s) assigned to this user</x-label>
                                <x-description>
                                    Roles control what users can do inside of Nova. You can assign as many roles as
                                    needed to users.
                                </x-description>

                                <livewire:users-manage-roles />
                            </x-field>
                        </x-fieldset.group>
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
                </div>

                <div class="w-full max-w-md" x-show="isTab('bio')">
                    <livewire:dynamic-form :form="$form" :admin="true" />
                </div>

                <x-fieldset.controls>
                    <x-button type="submit" variant="primary">Add</x-button>
                    <x-button :href="route('admin.users.index')" variant="ghost">Cancel</x-button>
                </x-fieldset.controls>
            </x-form>
        </div>
    </x-spacing>
</x-admin-layout>
