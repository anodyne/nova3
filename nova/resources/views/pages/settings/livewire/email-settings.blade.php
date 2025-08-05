@use('Nova\Settings\Enums\Mailer')

<x-form action="" wire:submit="save">
    @json($errors)

    <x-fieldset>
        <x-fieldset.field-group constrained>
            <x-fieldset.field label="Subject prefix" id="subject_prefix" name="subject_prefix">
                <x-input.text wire:model.blur="form.subjectPrefix" placeholder="[USS Nova]"></x-input.text>
            </x-fieldset.field>

            <x-fieldset.field label="Reply to email address" id="reply_to" name="reply_to">
                <x-input.text wire:model.blur="form.replyTo" placeholder="reply-to-nova@example.com"></x-input.text>
            </x-fieldset.field>

            <x-fieldset.field
                label="Global from email address"
                id="from_address"
                name="from_address"
                :error="$errors->first('form.fromAddress')"
            >
                <x-input.text wire:model.blur="form.fromAddress"></x-input.text>
            </x-fieldset.field>

            <x-fieldset.field
                label="Global from email name"
                id="from_name"
                name="from_name"
                :error="$errors->first('form.fromName')"
            >
                <x-input.text wire:model.blur="form.fromName"></x-input.text>
            </x-fieldset.field>
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading>
            <x-icon :name="Icon::Photo"></x-icon>
            <x-fieldset.legend>Logo</x-fieldset.legend>
            <x-fieldset.description>
                You can upload a logo that will be used in the header of the emails sent from Nova.
            </x-fieldset.description>
        </x-fieldset.heading>

        <x-fieldset.field-group constrained>
            <x-fieldset.field id="logo" name="logo">
                <livewire:media-upload-image
                    :model="settings()"
                    media-collection-name="email-logo"
                    support-message="PNG or JPG (max. 5MB)"
                />
            </x-fieldset.field>
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading>
            <x-icon :name="Icon::Settings"></x-icon>
            <x-fieldset.legend>Configuration</x-fieldset.legend>
            <x-fieldset.description>
                Set your email configuration values and they’ll be written to the configuration file for you.
            </x-fieldset.description>
        </x-fieldset.heading>

        <x-fieldset.field-group constrained>
            <x-fieldset.field label="Mailer" id="mailer" name="mailer" :description="$form->mailer->getDescription()">
                <x-select wire:model.live="form.mailer">
                    @foreach (Mailer::cases() as $mailer)
                        <option value="{{ $mailer->value }}">{{ $mailer->getLabel() }}</option>
                    @endforeach
                </x-select>
            </x-fieldset.field>

            @if ($form->mailer === Mailer::Sendmail)
                <x-fieldset.field
                    label="Sendmail path"
                    description="While this is a sensible default for most servers, you may need to contact your web host to verify this is the correct configuration for Sendmail if your email isn't being delivered"
                    id="sendmail_path"
                    name="sendmail_path"
                >
                    <x-input.text wire:model.live="form.sendmailPath"></x-input.text>
                </x-fieldset.field>
            @endif

            @if ($form->mailer === Mailer::Smtp)
                <x-fieldset.field label="Host" id="smtp_host" name="smtp_host">
                    <x-input.text wire:model.live="form.smtpHost"></x-input.text>
                </x-fieldset.field>

                <x-fieldset.field label="Port" id="smtp_port" name="smtp_port">
                    <x-input.text wire:model.live="form.smtpPort"></x-input.text>
                </x-fieldset.field>

                <x-fieldset.field label="Username" id="smtp_username" name="smtp_username">
                    <x-input.text wire:model.live="form.smtpUsername"></x-input.text>
                </x-fieldset.field>

                <x-fieldset.field label="Password" id="smtp_password" name="smtp_password">
                    <x-input.password wire:model.live="form.smtpPassword"></x-input.password>
                </x-fieldset.field>

                <x-fieldset.field label="Encryption" id="smtp_encryption" name="smtp_encryption">
                    <flux:radio.group wire:model.live="form.smtpEncryption" variant="segmented" data-slot="control">
                        <flux:radio value="" label="No encryption" />
                        <flux:radio value="tls" label="TLS" />
                    </flux:radio.group>
                </x-fieldset.field>
            @endif

            @if ($form->mailer === Mailer::Mailgun)
                <x-fieldset.field label="Domain" id="mailgun_domain" name="mailgun_domain">
                    <x-input.text wire:model.live="form.mailgunDomain')"></x-input.text>
                </x-fieldset.field>

                <x-fieldset.field label="Secret" id="mailgun_secret" name="mailgun_secret">
                    <x-input.password wire:model.live="form.mailgunSecret')"></x-input.password>
                </x-fieldset.field>

                <x-fieldset.field label="Endpoint" id="mailgun_endpoint" name="mailgun_endpoint">
                    <x-input.text wire:model.live="form.mailgunEndpoint')"></x-input.text>
                </x-fieldset.field>
            @endif

            @if ($form->mailer === Mailer::Postmark)
                <x-fieldset.field label="Token" id="postmark_token" name="postmark_token">
                    <x-input.text wire:model.live="form.postmarkToken"></x-input.text>
                </x-fieldset.field>
            @endif

            @if ($form->mailer === Mailer::MailerSend)
                <x-fieldset.field label="API key" id="mailersend_api_key" name="mailersend_api_key">
                    <x-input.text wire:model.live="form.mailersendApiKey"></x-input.text>
                </x-fieldset.field>
            @endif

            @if ($form->mailer === Mailer::Resend)
                <x-fieldset.field label="API key" id="resend_api_key" name="resend_api_key">
                    <x-input.text wire:model.live="form.resendApiKey"></x-input.text>
                </x-fieldset.field>
            @endif

            @if ($form->mailer === Mailer::Ses)
                <x-fieldset.field label="AWS access key ID" id="aws_access_key_id" name="aws_access_key_id">
                    <x-input.text wire:model.live="form.awsAccessKeyId')"></x-input.text>
                </x-fieldset.field>

                <x-fieldset.field label="AWS secret access key" id="aws_secret_access_key" name="aws_secret_access_key">
                    <x-input.password wire:model.live="form.awsSecretAccessKey')"></x-input.password>
                </x-fieldset.field>

                <x-fieldset.field label="AWS default region" id="aws_default_region" name="aws_default_region">
                    <x-input.text wire:model.live="form.awsDefaultRegion')"></x-input.text>
                </x-fieldset.field>
            @endif
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset.controls>
        <x-button type="submit" color="primary">Update</x-button>
    </x-fieldset.controls>
</x-form>
