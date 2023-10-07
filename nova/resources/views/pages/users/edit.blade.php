@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header :title="$user->name">
            <x-slot name="actions">
                <x-button.text :href="route('users.index')" leading="arrow-left" color="gray">Back</x-button.text>
            </x-slot>
        </x-panel.header>

        <x-form :action="route('users.update', $user)" method="PUT">
            <x-form.section
                title="User info"
                message="For privacy reasons, we don't recommend using a user's real name. Instead, use a nickname to help protect their identity."
                x-data="{
                    pronouns: '{{ old('pronouns.value', $user->pronouns->value) }}',
                    pronounSubject: '{{ old('pronouns.subject', $user->pronouns->subject) }}',
                    pronounObject: '{{ old('pronouns.object', $user->pronouns->object) }}',
                    pronounPossessive: '{{ old('pronouns.possessive', $user->pronouns->possessive) }}'
                }"
                x-init="
                    $watch('pronouns', (value, oldValue) => {
                        if (value !== oldValue) {
                            pronounSubject = '';
                            pronounObject = '';
                            pronounPossessive = '';
                        }
                    })
                "
            >
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $user->name)" data-cy="name" />
                </x-input.group>

                <x-input.group label="Email address" for="email" :error="$errors->first('email')">
                    <x-input.email id="email" name="email" :value="old('email', $user->email)" data-cy="email" />
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
            </x-form.section>

            <x-form.section
                title="Avatar"
                message="User avatars should be a square image at least 500 pixels tall by 500 pixels wide, but not more than 5MB in size."
            >
                <x-input.group>
                    @livewire('media:upload-avatar', ['existingAvatar' => $user->avatar_url])
                </x-input.group>
            </x-form.section>

            <x-form.section title="Characters assigned to this user">
                <x-slot name="message">
                    <p>
                        <strong>Please note:</strong>
                        changes to character assignment are immediate and will not be rolled back when pressing Cancel.
                    </p>
                </x-slot>

                <x-panel>
                    <livewire:users-manage-characters :user="$user" />
                </x-panel>
            </x-form.section>

            <x-form.section title="Roles assigned to this user">
                <x-slot name="message">
                    <p>
                        Roles control what users can do inside of Nova. You can assign as many roles as needed to users.
                    </p>
                    <p>
                        <strong>Please note:</strong>
                        changes to role assignment are immediate and will not be rolled back when pressing Cancel.
                    </p>
                </x-slot>

                <x-panel>
                    <livewire:users-manage-roles :user="$user" />
                </x-panel>
            </x-form.section>

            <x-form.footer>
                <x-button.filled type="submit" color="primary">Update</x-button.filled>
                <x-button.filled :href="route('users.index')" color="neutral">Cancel</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>

    @canany(['activate', 'deactivate', 'forcePasswordReset'], $user)
        <x-panel>
            <x-content-box class="flex flex-col gap-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Actions</h3>

                @can('activate', $user)
                    <x-panel as="light-well">
                        <x-content-box class="sm:flex sm:items-start sm:justify-between">
                            <h4 class="sr-only">Visa</h4>
                            <div class="sm:flex sm:items-start">
                                <x-icon name="check" size="lg"></x-icon>
                                <div class="mt-3 sm:ml-4 sm:mt-0">
                                    <div class="text-sm font-medium text-gray-900">Activate user</div>
                                    <div class="mt-1 max-w-2xl text-sm text-gray-600 sm:flex sm:items-center">
                                        When activating the user, their primary character will also be activated and
                                        their access roles will be set to the default roles for new users.
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 sm:ml-6 sm:mt-0 sm:flex-shrink-0">
                                <x-button.filled type="button" color="neutral">Activate</x-button.filled>
                            </div>
                        </x-content-box>
                    </x-panel>
                @endcan

                @can('deactivate', $user)
                    <x-panel as="light-well">
                        <x-content-box>
                            <div class="text-base font-semibold text-gray-900 dark:text-white">Deactivate user</div>
                            <div class="mt-1 max-w-3xl text-sm/6 text-gray-600 sm:flex sm:items-center">
                                When deactivating this user, all characters associated with their account that are not
                                jointly owned with another user will be deactivated as well.
                            </div>
                            <div class="mt-5">
                                <x-button.filled type="button" color="neutral">Deactivate</x-button.filled>
                            </div>
                        </x-content-box>
                    </x-panel>
                @endcan

                @can('forcePasswordReset', $user)
                    <x-panel as="light-well">
                        <x-content-box>
                            <div class="text-base font-semibold text-gray-900 dark:text-white">
                                Force password reset
                            </div>
                            <div class="mt-1 max-w-3xl text-sm/6 text-gray-600 sm:flex sm:items-center">
                                If you believe this user should reset their password, you can force a password reset
                                that will prompt them to change their password the next time they attempt to sign in.
                            </div>
                            <div class="mt-5">
                                <x-button.filled type="button" color="neutral">Force password reset</x-button.filled>
                            </div>
                        </x-content-box>
                    </x-panel>
                @endcan
            </x-content-box>
        </x-panel>
    @endcanany
@endsection
