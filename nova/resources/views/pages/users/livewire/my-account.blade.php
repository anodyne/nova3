@use('Nova\Stories\Enums\ContentRatingValue')

<div class="space-y-12" wire:key="account-info">
    <x-fieldset>
        <x-fieldset.group constrained>
            <x-input label="Name" name="name" wire:model.live.debounce="form.name" />

            <x-input.email label="Email address" name="email" wire:model.live.debounce="form.email" />

            <x-select label="Pronouns" name="pronouns" class="w-auto" wire:model.live="form.pronouns">
                <option value="none">Prefer not to share</option>
                <option value="male">He/Him</option>
                <option value="female">She/Her</option>
                <option value="neutral">They/Them</option>
                <option value="other">Other pronouns not listed (please specify)</option>
            </x-select>

            @if ($form->pronouns === 'other')
                <div class="space-y-6">
                    <x-input
                        label="What is your subject pronoun?"
                        name="pronouns_subject"
                        wire:model.live="form.pronounSubject"
                        placeholder="He, she, they, ze, etc."
                    />

                    <x-input
                        label="What is your object pronoun?"
                        name="pronouns_object"
                        wire:model.live="form.pronounObject"
                        placeholder="Him, her, them, zir, etc."
                    />
                </div>
            @endif
        </x-fieldset.group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading :icon="Tabler::Key" heading="Change password">
            <x-description>
                This will be used to sign in to your account and complete high severity actions. We recommend using a
                secure password or passphrase that you don’t use anywhere else.
            </x-description>
        </x-fieldset.heading>

        <x-fieldset.group constrained>
            <x-input.password
                label="Current password"
                name="current_password"
                wire:model.live.debounce="form.currentPassword"
            />

            <x-input.password label="New password" name="new_password" wire:model.live.debounce="form.newPassword" />

            <x-input.password
                label="Confirm new password"
                name="confirm_password"
                wire:model.live.debounce="form.newPasswordConfirmation"
            />
        </x-fieldset.group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading :icon="Tabler::UserCircle" heading="Profile photo">
            <x-description>
                Your user profile photo should be a square image at least 500 pixels tall by 500 pixels wide, but not
                more than 10MB in size.
            </x-description>

            <x-description>
                <strong>Note:</strong>
                if you don’t upload a user profile photo, a unique placeholder will be generated for your account.
            </x-description>
        </x-fieldset.heading>

        <x-fieldset.group constrained>
            <x-field>
                <livewire:media-upload-avatar :model="auth()->user()" />
            </x-field>
        </x-fieldset.group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading :icon="Tabler::Adjustments" heading="My preferences">
            <x-description>
                You can update your personal preferences to change the way Nova looks and behaves for your own account.
            </x-description>
        </x-fieldset.heading>

        <x-fieldset.group constrained>
            <x-select variant="listbox" placeholder="Choose a timezone" wire:model="form.timezone" searchable>
                @foreach ($timezones as $tz)
                    <option value="{{ $tz->id }}">{{ $tz->name }}</option>
                @endforeach
            </x-select>

            <x-field>
                <x-label>Admin appearance mode</x-label>
                <livewire:users-admin-appearance />
            </x-field>
        </x-fieldset.group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading :icon="Tabler::AlertTriangle" heading="Content rating warning thresholds">
            <x-description>
                You can choose to be warned about potentially offensive content in a story post if that post meets
                certain thresholds.
                <strong>Note:</strong>
                this only applies when viewing story posts from the admin panel.
            </x-description>
        </x-fieldset.heading>

        <x-fieldset.group constrained>
            <x-field>
                <x-label>Warn me when the language rating for a post is at or above</x-label>

                @if ($form->languageContentRatingWarningThreshold->value < settings('ratings.language.rating')->value)
                    <x-description.warning>
                        You have chosen to be warned about profane content in posts, but your threshold is set below the
                        default rating for this category. This means that you will have to manually agree to a warning
                        before being allowed to read every story post unless an author specifically sets the category
                        rating lower for their post.
                    </x-description.warning>
                @endif

                <x-radio.group wire:model.live="form.languageContentRatingWarningThreshold" variant="segmented">
                    @foreach (ContentRatingValue::casesForUserThreshold() as $rating)
                        <x-radio :value="$rating->value" :label="$rating->getLabelForThreshold()" />
                    @endforeach
                </x-radio.group>
            </x-field>

            <x-field>
                <x-label>Warn me when the sex rating for a post is at or above</x-label>

                @if ($form->sexContentRatingWarningThreshold->value < settings('ratings.sex.rating')->value)
                    <x-description.warning>
                        You have chosen to be warned about sexual content in posts, but your threshold is set below the
                        default rating for this category. This means that you will have to manually agree to a warning
                        before being allowed to read every story post unless an author specifically sets the category
                        rating lower for their post.
                    </x-description.warning>
                @endif

                <x-radio.group wire:model.live="form.sexContentRatingWarningThreshold" variant="segmented">
                    @foreach (ContentRatingValue::casesForUserThreshold() as $rating)
                        <x-radio :value="$rating->value" :label="$rating->getLabelForThreshold()" />
                    @endforeach
                </x-radio.group>
            </x-field>

            <x-field>
                <x-label>Warn me when the violence rating for a post is at or above</x-label>

                @if ($form->violenceContentRatingWarningThreshold->value < settings('ratings.violence.rating')->value)
                    <x-description.warning>
                        You have chosen to be warned about violent content in posts, but your threshold is set below the
                        default rating for this category. This means that you will have to manually agree to a warning
                        before being allowed to read every story post unless an author specifically sets the category
                        rating lower for their post.
                    </x-description.warning>
                @endif

                <x-radio.group wire:model.live="form.violenceContentRatingWarningThreshold" variant="segmented">
                    @foreach (ContentRatingValue::casesForUserThreshold() as $rating)
                        <x-radio :value="$rating->value" :label="$rating->getLabelForThreshold()" />
                    @endforeach
                </x-radio.group>
            </x-field>
        </x-fieldset.group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading :icon="Tabler::Trash" heading="Delete my account">
            <x-description>
                If you would like to permanently delete your account from the system, you can do so from the page linked
                below.
            </x-description>

            <x-button :href="route('admin.account.delete')">
                Delete my account
                <span aria-hidden="true">→</span>
            </x-button>
        </x-fieldset.heading>
    </x-fieldset>

    <x-fieldset.controls>
        <x-button type="button" wire:click="save" variant="primary">Update</x-button>
    </x-fieldset.controls>
</div>
