<div class="divide-y divide-gray-100 dark:divide-gray-800">
    <x-form.section
        title="User info"
        message="For privacy reasons, we don't recommend using your real name. Instead, use a nickname to help protect your identity."
    >
        <x-input.group label="Name" for="name" :error="$errors->first('form.name')">
            <x-input.text wire:model.live.debounce="form.name" />
        </x-input.group>

        <x-input.group label="Email address" for="email" :error="$errors->first('form.email')">
            <x-input.email wire:model.live.debounce="form.email" />
        </x-input.group>

        <x-input.group label="Pronouns" for="pronouns" :error="$errors->first('pronouns.value')">
            <x-input.select class="w-auto" wire:model.live="form.pronouns">
                <option value="none">Prefer not to share</option>
                <option value="male">He/Him/His</option>
                <option value="female">She/Her/Hers</option>
                <option value="neutral">They/Them/Theirs</option>
                <option value="neo">Ze/Zir/Zirs</option>
                <option value="other">Other pronouns not listed (please specify)</option>
            </x-input.select>
        </x-input.group>

        @if ($form->pronouns === 'other')
            <div class="space-y-6">
                <x-input.group
                    label="What is your subject pronoun?"
                    for="pronouns-subject"
                    :error="$errors->first('form.pronounSubject')"
                >
                    <x-input.text wire:model.live="form.pronounSubject" placeholder="He, she, they, ze, etc." />
                </x-input.group>

                <x-input.group
                    label="What is your object pronoun?"
                    for="pronouns-object"
                    :error="$errors->first('form.pronounObject')"
                >
                    <x-input.text wire:model.live="form.pronounObject" placeholder="Him, her, them, zir, etc." />
                </x-input.group>

                <x-input.group
                    label="What is your possessive pronoun?"
                    for="pronouns-possessive"
                    :error="$errors->first('form.pronounPossessive')"
                >
                    <x-input.text
                        wire:model.live="form.pronounPossessive"
                        placeholder="His, hers, theirs, zirs, etc."
                    />
                </x-input.group>
            </div>
        @endif
    </x-form.section>

    <x-form.section
        title="Change password"
        message="This will be used to sign in to your account and complete high severity actions. We recommend using a secure password or passphrase that you don't use anywhere else."
    >
        <x-input.group label="Current password" :error="$errors->first('form.currentPassword')">
            <x-input.password wire:model.live.debounce="form.currentPassword"></x-input.password>
        </x-input.group>

        <x-input.group label="New password">
            <x-input.password wire:model.live.debounce="form.newPassword"></x-input.password>
        </x-input.group>

        <x-input.group label="Confirm new password" :error="$errors->first('form.newPasswordConfirmation')">
            <x-input.password wire:model.live.debounce="form.newPasswordConfirmation"></x-input.password>
        </x-input.group>
    </x-form.section>

    <x-form.section title="Image">
        <x-slot name="message">
            <p>
                Your user image should be a square image at least 500 pixels tall by 500 pixels wide, but not more than
                10MB in size.
            </p>

            <p>
                <strong class="font-semibold">Note:</strong>
                if you don't upload a user image, a unique placeholder will be generated for your account.
            </p>
        </x-slot>

        <x-input.group>
            <livewire:media-upload-avatar :model="auth()->user()" />
        </x-input.group>
    </x-form.section>

    <x-form.footer>
        <x-button.filled type="button" wire:click="save" color="primary">Update</x-button.filled>
    </x-form.footer>
</div>
