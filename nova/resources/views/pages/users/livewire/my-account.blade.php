@use('Nova\Stories\Enums\ContentRatingValue')

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
                    <option value="male">He/Him</option>
                    <option value="female">She/Her</option>
                    <option value="neutral">They/Them</option>
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
            <x-fieldset.legend>Profile photo</x-fieldset.legend>
            <x-fieldset.description>
                Your user profile photo should be a square image at least 500 pixels tall by 500 pixels wide, but not
                more than 10MB in size.

                <x-fieldset.description class="mt-4">
                    <x-text.strong>Note:</x-text.strong>
                    if you don’t upload a user profile photo, a unique placeholder will be generated for your account.
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
            <flux:field>
                <flux:label>Timezone</flux:label>

                <flux:select variant="listbox" placeholder="Choose timezone" wire:model.live="form.timezone" searchable>
                    @foreach ($timezones as $tz)
                        <flux:option value="{{ $tz->id }}">{{ $tz->name }}</flux:option>
                    @endforeach
                </flux:select>
            </flux:field>

            <x-switch.field>
                <x-fieldset.label>Dark mode</x-fieldset.label>
                <x-fieldset.description>Show the admin panel in dark mode</x-fieldset.description>
                <flux:switch x-data x-model="$flux.dark" />
            </x-switch.field>
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading>
            <x-icon name="warning"></x-icon>
            <x-fieldset.legend>Content rating warning thresholds</x-fieldset.legend>
            <x-fieldset.description>
                You can choose to be warned about potentially offensive content in a story post if that post meets
                certain thresholds.
                <x-text.strong>Note:</x-text.strong>
                this only applies when viewing story posts from the admin panel.
            </x-fieldset.description>
        </x-fieldset.heading>

        <x-fieldset.field-group constrained>
            <x-fieldset.field
                label="Warn me when the language rating for a post is at or above"
                id="languageContentRatingWarningThreshold"
                name="languageContentRatingWarningThreshold"
            >
                @if ($form->languageContentRatingWarningThreshold->value < settings('ratings.language.rating')->value)
                    <x-fieldset.warning-message>
                        You have chosen to be warned about profane content in posts, but your threshold is set below the
                        default rating for this category. This means that you will have to manually agree to a warning
                        before being allowed to read every story post unless an author specifically sets the category
                        rating lower for their post.
                    </x-fieldset.warning-message>
                @endif

                <flux:radio.group
                    wire:model.live="form.languageContentRatingWarningThreshold"
                    variant="segmented"
                    data-slot="control"
                >
                    @foreach (ContentRatingValue::casesForUserThreshold() as $rating)
                        <flux:radio :value="$rating->value" :label="$rating->getLabelForThreshold()" />
                    @endforeach
                </flux:radio.group>
            </x-fieldset.field>

            <x-fieldset.field
                label="Warn me when the sex rating for a post is at or above"
                id="sexContentRatingWarningThreshold-"
                name="sexContentRatingWarningThreshold-"
            >
                @if ($form->sexContentRatingWarningThreshold->value < settings('ratings.sex.rating')->value)
                    <x-fieldset.warning-message>
                        You have chosen to be warned about sexual content in posts, but your threshold is set below the
                        default rating for this category. This means that you will have to manually agree to a warning
                        before being allowed to read every story post unless an author specifically sets the category
                        rating lower for their post.
                    </x-fieldset.warning-message>
                @endif

                <flux:radio.group
                    wire:model.live="form.sexContentRatingWarningThreshold"
                    variant="segmented"
                    data-slot="control"
                >
                    @foreach (ContentRatingValue::casesForUserThreshold() as $rating)
                        <flux:radio :value="$rating->value" :label="$rating->getLabelForThreshold()" />
                    @endforeach
                </flux:radio.group>
            </x-fieldset.field>

            <x-fieldset.field
                label="Warn me when the violence rating for a post is at or above"
                id="violenceContentRatingWarningThreshold"
                name="violenceContentRatingWarningThreshold"
            >
                @if ($form->violenceContentRatingWarningThreshold->value < settings('ratings.violence.rating')->value)
                    <x-fieldset.warning-message>
                        You have chosen to be warned about violent content in posts, but your threshold is set below the
                        default rating for this category. This means that you will have to manually agree to a warning
                        before being allowed to read every story post unless an author specifically sets the category
                        rating lower for their post.
                    </x-fieldset.warning-message>
                @endif

                <flux:radio.group
                    wire:model.live="form.violenceContentRatingWarningThreshold"
                    variant="segmented"
                    data-slot="control"
                >
                    @foreach (ContentRatingValue::casesForUserThreshold() as $rating)
                        <flux:radio :value="$rating->value" :label="$rating->getLabelForThreshold()" />
                    @endforeach
                </flux:radio.group>
            </x-fieldset.field>
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
            <x-button :href="route('admin.account.delete')">Delete my account &rarr;</x-button>
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset.controls>
        <x-button type="button" wire:click="save" color="primary">Update</x-button>
    </x-fieldset.controls>
</div>
