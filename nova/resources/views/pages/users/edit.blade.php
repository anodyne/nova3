@extends($meta->template)

@section('content')
    <x-container.narrow>
        <x-page-header>
            <x-slot name="heading">{{ $user->name }}</x-slot>

            <x-slot name="actions">
                <x-button :href="route('users.index')" plain>&larr; Back</x-button>
            </x-slot>
        </x-page-header>

        <div
            x-data="{
                pronouns: '{{ old('pronouns.value', $user->pronouns->value) }}',
                pronounSubject: '{{ old('pronouns.subject', $user->pronouns->subject) }}',
                pronounObject: '{{ old('pronouns.object', $user->pronouns->object) }}',
                pronounPossessive:
                    '{{ old('pronouns.possessive', $user->pronouns->possessive) }}',
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
            <x-form :action="route('users.update', $user)" method="PUT">
                <x-fieldset>
                    <x-fieldset.field-group class="w-full max-w-md">
                        <x-input.group
                            label="Name"
                            for="name"
                            :error="$errors->first('name')"
                            help="For privacy reasons, consider using a nickname rather than a user’s real name."
                        >
                            <x-input.text id="name" name="name" :value="old('name', $user->name)" data-cy="name" />
                        </x-input.group>

                        <x-input.group label="Email address" for="email" :error="$errors->first('email')">
                            <x-input.email
                                id="email"
                                name="email"
                                :value="old('email', $user->email)"
                                data-cy="email"
                            />
                        </x-input.group>

                        <x-input.group label="Password">
                            <x-text>
                                Only users can update their current password. If a user is unable to sign in, they can
                                use the reset password page or an admin can force a password reset.
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

                        <livewire:media-upload-avatar :model="$user" />
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
                            <livewire:users-manage-characters :user="$user" />
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
                            <livewire:users-manage-roles :user="$user" />
                        </x-container>
                    </x-panel>
                </x-fieldset>

                @canany(['activate', 'deactivate', 'forcePasswordReset'], $user)
                    <x-fieldset>
                        <x-panel well>
                            <x-container width="sm" height="sm">
                                <x-fieldset.legend>Administrative actions</x-fieldset.legend>
                            </x-container>

                            <x-container height="2xs" width="2xs">
                                <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                                    @can('activate', $user)
                                        <x-container height="sm" class="grid grid-cols-3 gap-6">
                                            <div class="col-span-2">
                                                <div class="flex items-center gap-2">
                                                    <x-icon name="check" size="sm" class="text-gray-500"></x-icon>
                                                    <x-h4>Activate character</x-h4>
                                                </div>
                                                <x-text class="mt-2">
                                                    When activating the user, their primary character will also be
                                                    activated and their access roles will be set to the default roles
                                                    for new users.
                                                </x-text>
                                            </div>
                                            <div class="flex items-start justify-end">
                                                <livewire:users-activate-button :user="$user" />
                                            </div>
                                        </x-container>
                                    @endcan

                                    @can('deactivate', $user)
                                        <x-container height="sm" class="grid grid-cols-3 gap-6">
                                            <div class="col-span-2">
                                                <div class="flex items-center gap-2">
                                                    <x-icon name="remove" size="sm" class="text-gray-500"></x-icon>
                                                    <x-h4>Deactivate user</x-h4>
                                                </div>
                                                <x-text class="mt-2">
                                                    When deactivating this user, all characters associated with their
                                                    account that are not jointly owned with another user will be
                                                    deactivated as well.
                                                </x-text>
                                            </div>
                                            <div class="flex items-start justify-end">
                                                <livewire:users-deactivate-button :user="$user" />
                                            </div>
                                        </x-container>
                                    @endcan

                                    @can('forcePasswordReset', $user)
                                        <x-container height="sm" class="grid grid-cols-3 gap-6">
                                            <div class="col-span-2">
                                                <div class="flex items-center gap-2">
                                                    <x-icon name="lock-closed" size="sm" class="text-gray-500"></x-icon>
                                                    <x-h4>Force password reset</x-h4>
                                                </div>
                                                <x-text class="mt-2">
                                                    If you believe this user should reset their password, you can force
                                                    a password reset that will prompt them to change their password the
                                                    next time they sign in.
                                                </x-text>
                                            </div>
                                            <div class="flex items-start justify-end">
                                                <livewire:users-force-password-reset-button :user="$user" />
                                            </div>
                                        </x-container>
                                    @endcan
                                </x-panel>
                            </x-container>
                        </x-panel>
                    </x-fieldset>
                @endcanany

                <x-fieldset>
                    <div class="flex gap-x-2 lg:flex-row-reverse">
                        <x-button type="submit" color="primary">Update</x-button>
                        <x-button :href="route('users.index')" plain>Cancel</x-button>
                    </div>
                </x-fieldset>
            </x-form>
        </div>
    </x-container.narrow>
@endsection
