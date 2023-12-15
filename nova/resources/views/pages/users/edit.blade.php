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

            <x-form.section title="Image">
                <x-slot name="message">
                    <p>
                        User images should be a square image at least 500 pixels tall by 500 pixels wide, but not more
                        than 10MB in size.
                    </p>

                    <p>
                        <strong class="font-semibold">Note:</strong>
                        if a user image isn't uploaded, a unique placeholder will be generated for the account.
                    </p>
                </x-slot>

                <x-input.group>
                    <livewire:media-upload-avatar :model="$user" />
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Characters assigned to this user"
                message="Users can be assigned as many characters as you want."
            >
                <livewire:users-manage-characters :user="$user" />
            </x-form.section>

            <x-form.section
                title="Roles assigned to this user"
                message="Roles control what users can do inside of Nova. You can assign as many roles as needed to users."
            >
                <livewire:users-manage-roles :user="$user" />
            </x-form.section>

            @canany(['activate', 'deactivate', 'forcePasswordReset'], $user)
                <x-form.section title="Admin actions">
                    <x-panel class="overflow-hidden">
                        <div class="divide-y divide-gray-200 dark:divide-gray-800">
                            @can('activate', $user)
                                <x-content-box height="sm" class="grid grid-cols-3 gap-6 bg-white dark:bg-gray-900">
                                    <div class="col-span-2">
                                        <div class="flex items-center gap-2">
                                            <x-icon name="check" size="md" class="text-gray-500"></x-icon>
                                            <x-h3>Activate character</x-h3>
                                        </div>
                                        <p class="mt-2 text-sm/6 text-gray-600 dark:text-gray-400">
                                            When activating the user, their primary character will also be activated and
                                            their access roles will be set to the default roles for new users.
                                        </p>
                                    </div>
                                    <div class="flex items-start justify-end">
                                        <livewire:users-activate-button :user="$user" />
                                    </div>
                                </x-content-box>
                            @endcan

                            @can('deactivate', $user)
                                <x-content-box height="sm" class="grid grid-cols-3 gap-6 bg-white dark:bg-gray-900">
                                    <div class="col-span-2">
                                        <div class="flex items-center gap-2">
                                            <x-icon name="remove" size="md" class="text-gray-500"></x-icon>
                                            <x-h3>Deactivate user</x-h3>
                                        </div>
                                        <p class="mt-2 text-sm/6 text-gray-600 dark:text-gray-400">
                                            When deactivating this user, all characters associated with their account
                                            that are not jointly owned with another user will be deactivated as well.
                                        </p>
                                    </div>
                                    <div class="flex items-start justify-end">
                                        <livewire:users-deactivate-button :user="$user" />
                                    </div>
                                </x-content-box>
                            @endcan

                            @can('forcePasswordReset', $user)
                                <x-content-box height="sm" class="grid grid-cols-3 gap-6 bg-white dark:bg-gray-900">
                                    <div class="col-span-2">
                                        <div class="flex items-center gap-2">
                                            <x-icon name="lock-closed" size="md" class="text-gray-500"></x-icon>
                                            <x-h3>Force password reset</x-h3>
                                        </div>
                                        <p class="mt-2 text-sm/6 text-gray-600 dark:text-gray-400">
                                            If you believe this user should reset their password, you can force a
                                            password reset that will prompt them to change their password the next time
                                            they sign in.
                                        </p>
                                    </div>
                                    <div class="flex items-start justify-end">
                                        <livewire:users-force-password-reset-button :user="$user" />
                                    </div>
                                </x-content-box>
                            @endcan
                        </div>
                    </x-panel>
                </x-form.section>
            @endcanany

            <x-form.footer>
                <x-button.filled type="submit" color="primary">Update</x-button.filled>
                <x-button.filled :href="route('users.index')" color="neutral">Cancel</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
