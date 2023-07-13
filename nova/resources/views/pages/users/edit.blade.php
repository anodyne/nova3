@extends($meta->template)

@section('content')
    <x-panel x-data="tabsList('details')">
        <x-panel.header :title="$user->name">
            <x-slot>
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
                <x-slot>
                    <p>
                        <strong>Please note:</strong>
                        changes to character assignment are immediate and will not be rolled back when pressing Cancel.
                    </p>
                </x-slot>

                <x-panel>
                    @livewire('users:manage-characters', ['user' => $user])
                </x-panel>
            </x-form.section>

            <x-form.section title="Roles assigned to this user">
                <x-slot>
                    <p>
                        Roles control what users can do inside of Nova. You can assign as many roles as needed to users.
                    </p>
                    <p>
                        <strong>Please note:</strong>
                        changes to role assignment are immediate and will not be rolled back when pressing Cancel.
                    </p>
                </x-slot>

                <x-panel>
                    @livewire('users:manage-roles', ['user' => $user])
                </x-panel>
            </x-form.section>

            <x-form.footer>
                <x-button.filled type="submit" color="primary">Update</x-button.filled>
                <x-button.outline :href="route('users.index')" color="gray">Cancel</x-button.outline>
            </x-form.footer>
        </x-form>
    </x-panel>

    @can('deactivate', $user)
        <x-panel class="mt-8">
            <x-content-box>
                <x-h3>Deactivate user</x-h3>

                <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                    <div class="w-full">
                        <p>
                            When deactivating this user, all characters associated with their account that are not
                            jointly owned with another user will be deactivated as well.
                        </p>
                    </div>
                    <div class="mt-5 sm:ml-8 sm:mt-0 sm:flex sm:shrink-0 sm:items-center">
                        <x-form :action="route('users.deactivate', $user)">
                            <x-button.outline type="submit" color="danger">Deactivate user</x-button.outline>
                        </x-form>
                    </div>
                </div>
            </x-content-box>
        </x-panel>
    @endcan

    @can('activate', $user)
        <x-panel class="mt-8">
            <x-content-box>
                <x-h3>Activate user</x-h3>

                <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                    <div class="w-full">
                        <p>
                            When activating the user, their primary character will also be activated and their access
                            roles will be set to the default roles for new users.
                        </p>
                    </div>
                    <div class="mt-5 sm:ml-8 sm:mt-0 sm:flex sm:shrink-0 sm:items-center">
                        <x-form :action="route('users.activate', $user)">
                            <x-button.outline type="submit" color="primary">Activate user</x-button.outline>
                        </x-form>
                    </div>
                </div>
            </x-content-box>
        </x-panel>
    @endcan

    @can('forcePasswordReset', $user)
        <x-panel class="mt-8">
            <x-content-box>
                <x-h3>Account security</x-h3>

                <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                    <div class="w-full">
                        <p>
                            If you believe this user should reset their password, you can force a password reset that
                            will prompt them to change their password the next time they attempt to sign in.
                        </p>
                    </div>
                    <div class="mt-5 sm:ml-8 sm:mt-0 sm:flex sm:shrink-0 sm:items-center">
                        <x-form :action="route('users.force-password-reset', $user)">
                            <x-button.outline type="submit">Force password reset</x-button.outline>
                        </x-form>
                    </div>
                </div>
            </x-content-box>
        </x-panel>
    @endcan
@endsection
