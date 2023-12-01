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

    <x-form.section
        title="Image"
        message="Your user image should be a square image at least 500 pixels tall by 500 pixels wide, but not more than 5MB in size."
    >
        <x-input.group>
            @livewire('media:upload-avatar', ['existingAvatar' => auth()->user()->avatar_url])
        </x-input.group>
    </x-form.section>

    <x-form.section
        title="Delete account"
        message="This will delete your account and you will no longer be able to interact with the game."
    >
        <div>
            <p class="text-sm/6 text-gray-600 dark:text-gray-400">The following information will be deleted:</p>
            <div class="mt-2 grid grid-cols-2 gap-4">
                <div class="flex items-center gap-x-2">
                    <div class="shrink-0">
                        <x-icon name="user" size="md"></x-icon>
                    </div>
                    <div>
                        <x-h4>User account</x-h4>
                    </div>
                </div>
                <div class="flex items-center gap-x-2">
                    <div class="shrink-0">
                        <x-icon name="login" size="md"></x-icon>
                    </div>
                    <div>
                        <x-h4>Log in records</x-h4>
                    </div>
                </div>
                <div class="flex items-center gap-x-2">
                    <div class="shrink-0">
                        <x-icon name="note" size="md"></x-icon>
                    </div>
                    <div>
                        <x-h4>Notes</x-h4>
                    </div>
                </div>
            </div>

            <p class="mt-8 text-sm/6 text-gray-600 dark:text-gray-400">
                The following information will not be deleted:
            </p>
            <div class="mt-2 grid grid-cols-2 gap-4">
                <div class="flex items-center gap-x-2">
                    <div class="shrink-0">
                        <x-icon name="characters" size="md"></x-icon>
                    </div>
                    <div>
                        <x-h4>Characters</x-h4>
                    </div>
                </div>
                <div class="flex items-center gap-x-2">
                    <div class="shrink-0">
                        <x-icon name="book" size="md"></x-icon>
                    </div>
                    <div>
                        <x-h4>Story posts</x-h4>
                    </div>
                </div>
                <div class="flex items-center gap-x-2">
                    <div class="shrink-0">
                        <x-icon name="megaphone" size="md"></x-icon>
                    </div>
                    <div>
                        <x-h4>Announcements</x-h4>
                    </div>
                </div>
                <div class="flex items-center gap-x-2">
                    <div class="shrink-0">
                        <x-icon name="messages" size="md"></x-icon>
                    </div>
                    <div>
                        <x-h4>Direct messages</x-h4>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <x-dropdown placement="bottom-start">
                    <x-slot name="emptyTrigger">
                        <x-button.outlined color="danger" leading="trash">Delete my account</x-button.outlined>
                    </x-slot>

                    <x-dropdown.group>
                        <x-dropdown.text>
                            Are you sure you want to delete your account? This action is permanent and cannot be undone.
                        </x-dropdown.text>
                    </x-dropdown.group>
                    <x-dropdown.group>
                        <x-dropdown.item-danger type="button" icon="trash" wire:click="delete">
                            Delete
                        </x-dropdown.item-danger>
                        <x-dropdown.item
                            type="button"
                            icon="prohibited"
                            x-on:click.prevent="$dispatch('dropdown-close')"
                        >
                            Cancel
                        </x-dropdown.item>
                    </x-dropdown.group>
                </x-dropdown>
            </div>
        </div>
    </x-form.section>

    <x-form.footer>
        <x-button.filled type="button" wire:click="save" color="primary">Update</x-button.filled>
    </x-form.footer>
</div>
