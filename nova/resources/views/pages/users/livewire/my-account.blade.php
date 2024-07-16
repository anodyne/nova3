<div class="space-y-12" wire:key="account-info">
    <x-fieldset>
        <x-fieldset.field-group constrained>
            <x-fieldset.field label="Name" id="name" name="name" :error="$errors->first('form.name')">
                <x-input.text wire:model.live.debounce="form.name" />
            </x-fieldset.field>

            <x-fieldset.field label="Email address" id="email" name="email" :error="$errors->first('form.email')">
                <x-input.email wire:model.live.debounce="form.email" />
            </x-fieldset.field>

            <x-fieldset.field label="Pronouns" id="pronouns" name="pronouns" :error="$errors->first('pronouns.value')">
                <x-select class="w-auto" wire:model.live="form.pronouns">
                    <option value="none">Prefer not to share</option>
                    <option value="male">He/Him/His</option>
                    <option value="female">She/Her/Hers</option>
                    <option value="neutral">They/Them/Theirs</option>
                    <option value="neo">Ze/Zir/Zirs</option>
                    <option value="other">Other pronouns not listed (please specify)</option>
                </x-select>
            </x-fieldset.field>

            @if ($form->pronouns === 'other')
                <div class="space-y-6">
                    <x-fieldset.field
                        label="What is your subject pronoun?"
                        id="pronouns_subject"
                        name="pronouns_subject"
                        :error="$errors->first('form.pronounSubject')"
                    >
                        <x-input.text wire:model.live="form.pronounSubject" placeholder="He, she, they, ze, etc." />
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="What is your object pronoun?"
                        id="pronouns_object"
                        name="pronouns_object"
                        :error="$errors->first('form.pronounObject')"
                    >
                        <x-input.text wire:model.live="form.pronounObject" placeholder="Him, her, them, zir, etc." />
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="What is your possessive pronoun?"
                        id="pronouns_possessive"
                        name="pronouns_possessive"
                        :error="$errors->first('form.pronounPossessive')"
                    >
                        <x-input.text
                            wire:model.live="form.pronounPossessive"
                            placeholder="His, hers, theirs, zirs, etc."
                        />
                    </x-fieldset.field>
                </div>
            @endif
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading>
            <x-icon name="key"></x-icon>
            <x-fieldset.legend>Change password</x-fieldset.legend>
            <x-fieldset.description>
                This will be used to sign in to your account and complete high severity actions. We recommend using a
                secure password or passphrase that you don’t use anywhere else.
            </x-fieldset.description>
        </x-fieldset.heading>

        <x-fieldset.field-group constrained>
            <x-fieldset.field
                label="Current password"
                id="current_password"
                name="current_password"
                :error="$errors->first('form.currentPassword')"
            >
                <x-input.password wire:model.live.debounce="form.currentPassword"></x-input.password>
            </x-fieldset.field>

            <x-fieldset.field label="New password" id="new_password" name="new_password">
                <x-input.password wire:model.live.debounce="form.newPassword"></x-input.password>
            </x-fieldset.field>

            <x-fieldset.field
                label="Confirm new password"
                id="confirm_password"
                name="confirm_password"
                :error="$errors->first('form.newPasswordConfirmation')"
            >
                <x-input.password wire:model.live.debounce="form.newPasswordConfirmation"></x-input.password>
            </x-fieldset.field>
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading>
            <x-icon name="user-profile"></x-icon>
            <x-fieldset.legend>Image</x-fieldset.legend>
            <x-fieldset.description>
                Your user image should be a square image at least 500 pixels tall by 500 pixels wide, but not more than
                10MB in size.

                <x-fieldset.description class="mt-4">
                    <x-text.strong>Note:</x-text.strong>
                    if you don’t upload a user image, a unique placeholder will be generated for your account.
                </x-fieldset.description>
            </x-fieldset.description>
        </x-fieldset.heading>

        <x-fieldset.field-group constrained>
            <x-fieldset.field id="avatar" name="avatar">
                <livewire:media-upload-avatar :model="auth()->user()" />
            </x-fieldset.field>
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading>
            <x-icon name="preferences"></x-icon>
            <x-fieldset.legend>My preferences</x-fieldset.legend>
            <x-fieldset.description>
                You can update your personal preferences to change the way Nova looks and behaves for your own account.
            </x-fieldset.description>
        </x-fieldset.heading>

        <x-fieldset.field-group constrained>
            <x-fieldset.field label="Timezone" id="timezone" name="timezone" :error="$errors->first('form.timezone')">
                <x-input.text wire:model.live.debounce="form.timezone"></x-input.text>
            </x-fieldset.field>

            <x-switch.field>
                <x-fieldset.label>Dark mode</x-fieldset.label>
                <x-fieldset.description>Show the admin panel in dark mode</x-fieldset.description>
                <livewire:users-admin-theme-toggle />
            </x-switch.field>
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading>
            <x-icon name="trash"></x-icon>
            <x-fieldset.legend>Delete my account</x-fieldset.legend>
            <x-fieldset.description>
                If you would like to permanently delete your account from the system, you can do so from the page linked
                below.
            </x-fieldset.description>
        </x-fieldset.heading>

        <x-fieldset.field-group constrained>
            <x-button :href="route('account.delete')">Delete my account</x-button>
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset.controls>
        <x-button type="button" wire:click="save" color="primary">Update</x-button>
    </x-fieldset.controls>
</div>
