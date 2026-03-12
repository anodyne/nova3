@use('Nova\Settings\Enums\Mailer')

<x-form action="" wire:submit="save">
    <x-fieldset>
        <x-fieldset.group constrained>
            <x-input label="Subject prefix" wire:model.blur="form.subjectPrefix" placeholder="[USS Nova]"></x-input>

            <x-input
                label="Reply-to email address"
                wire:model.blur="form.replyTo"
                placeholder="reply-to-nova@example.com"
            ></x-input>

            <x-input label="Global from email address" wire:model.blur="form.fromAddress"></x-input>

            <x-input label="Global from email name" wire:model.blur="form.fromName"></x-input>
        </x-fieldset.group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading :icon="Tabler::Photo" heading="Logo">
            <x-description>
                You can upload a logo that will be used in the header of the emails sent from Nova.
            </x-description>
        </x-fieldset.heading>

        <x-fieldset.group constrained>
            <x-field>
                <livewire:media-upload-image
                    :model="settings()"
                    media-collection-name="logo-email"
                    support-message="PNG or JPG (max. 5MB)"
                    field-name="logo_email"
                />
            </x-field>
        </x-fieldset.group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading :icon="Tabler::Settings" heading="Configuration">
            <x-description>
                Set your email configuration values and they’ll be written to the configuration file for you.
            </x-description>
        </x-fieldset.heading>

        <x-fieldset.group constrained>
            <x-select label="Mailer" :description="$form->mailer->getDescription()" wire:model.live="form.mailer">
                @foreach (Mailer::cases() as $mailer)
                    <option value="{{ $mailer->value }}">{{ $mailer->getLabel() }}</option>
                @endforeach
            </x-select>

            @if ($form->mailer === Mailer::Sendmail)
                <x-input
                    label="Sendmail path"
                    description="While this is a sensible default for most servers, you may need to contact your web host to verify this is the correct configuration for Sendmail if your email isn't being delivered"
                    wire:model.live="form.sendmailPath"
                ></x-input>
            @endif

            @if ($form->mailer === Mailer::Smtp)
                <x-input label="Host" wire:model.blur="form.smtpHost"></x-input>

                <x-input label="Port" wire:model.blur="form.smtpPort"></x-input>

                <x-input label="Username" wire:model.blur="form.smtpUsername"></x-input>

                <x-input label="Password" type="password" wire:model.live="form.smtpPassword" viewable></x-input>

                <x-radio.group
                    label="Encryption"
                    wire:model.live="form.smtpEncryption"
                    variant="segmented"
                    data-slot="control"
                >
                    <x-radio value="" label="No encryption" />
                    <x-radio value="tls" label="TLS" />
                </x-radio.group>
            @endif

            @if ($form->mailer === Mailer::Mailgun)
                <x-input label="Domain" wire:model.blur="form.mailgunDomain"></x-input>

                <x-input label="Secret" wire:model.blur="form.mailgunSecret"></x-input>

                <x-input label="Endpoint" wire:model.blur="form.mailgunEndpoint"></x-input>
            @endif

            @if ($form->mailer === Mailer::Postmark)
                <x-input label="Token" wire:model.blur="form.postmarkToken"></x-input>
            @endif

            @if ($form->mailer === Mailer::MailerSend)
                <x-input label="API key" wire:model.blur="form.mailersendApiKey"></x-input>
            @endif

            @if ($form->mailer === Mailer::Resend)
                <x-input label="API key" wire:model.blur="form.resendApiKey"></x-input>
            @endif

            @if ($form->mailer === Mailer::Ses)
                <x-input label="AWS access key ID" wire:model.blur="form.awsAccessKeyId"></x-input>

                <x-input label="AWS secret access key" wire:model.blur="form.awsSecretAccessKey"></x-input>

                <x-input label="AWS default region" wire:model.blur="form.awsDefaultRegion"></x-input>
            @endif
        </x-fieldset.group>
    </x-fieldset>

    <x-fieldset.controls>
        <x-button type="submit" variant="primary">Update</x-button>
    </x-fieldset.controls>
</x-form>
