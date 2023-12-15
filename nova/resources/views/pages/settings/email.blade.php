@extends($meta->template)

@php($settings = settings('email'))

@section('content')
    <x-panel>
        <x-panel.header title="Email settings" message="Change the way Nova sends email">
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button.filled color="neutral" leading="search" x-on:click="$dispatch('toggle-spotlight')">
                        Find a setting
                    </x-button.filled>
                </div>
            </x-slot>
        </x-panel.header>

        <x-form :action="route('settings.update', $tab)" method="PUT" id="email">
            <x-form.section title="Basic settings">
                <x-input.group label="Subject prefix">
                    <x-input.text
                        name="subject_prefix"
                        :value="old('subject_prefix', $settings->subjectPrefix)"
                        placeholder="[USS Nova]"
                    ></x-input.text>
                </x-input.group>

                <x-input.group label="Reply to email address">
                    <x-input.text
                        name="reply_to"
                        :value="old('reply_to', $settings->replyTo)"
                        placeholder="reply-to-nova@example.com"
                    ></x-input.text>
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Global from address"
                message="You can define the email address and name used for all emails."
            >
                <x-input.group label="From email address">
                    <x-input.text name="from_address" :value="config('mail.from.address')"></x-input.text>
                </x-input.group>

                <x-input.group label="From email name">
                    <x-input.text name="from_name" :value="config('mail.from.name')"></x-input.text>
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Logo"
                message="You can upload a logo that will be used in the header of the emails sent from Nova."
            >
                <x-input.group>
                    <livewire:media-upload-image
                        :model="settings()"
                        media-collection-name="email-logo"
                        support-message="PNG or JPG (max. 5MB)"
                    />
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Configuration"
                message="You can set your email configuration values and they'll be written to the configuration file for you."
                x-data="{ mailer: '{{ config('mail.default') }}' }"
            >
                <x-input.group label="Mailer">
                    <x-input.select name="mailer" x-model="mailer">
                        <option value="sendmail">Sendmail</option>
                        <option value="smtp">SMTP</option>
                        <option value="mailgun">Mailgun</option>
                        <option value="postmark">Postmark</option>
                        <option value="ses">Amazon SES</option>
                        <option value="mailersend">MailerSend</option>
                    </x-input.select>

                    <x-slot name="help">
                        <span x-show="mailer === 'sendmail'" x-cloak>
                            While sendmail is the default mailer, we strongly recommend using a third-party SMTP
                            transactional email service to handle your email
                        </span>
                    </x-slot>
                </x-input.group>

                <div x-show="mailer === 'sendmail'" x-cloak>
                    <x-input.group
                        label="Sendmail path"
                        help="While this is a sensible default for most servers, you may need to contact your web host to verify this is the correct configuration for Sendmail if your email isn't being delivered"
                    >
                        <x-input.text
                            name="sendmail_path"
                            :value="old('sendmail_path', config('mail.mailers.sendmail.path'))"
                        ></x-input.text>
                    </x-input.group>
                </div>

                <div class="space-y-8" x-show="mailer === 'smtp'" x-cloak>
                    <x-input.group label="Host">
                        <x-input.text
                            name="smtp_host"
                            :value="old('smtp_host', config('mail.mailers.smtp.host'))"
                        ></x-input.text>
                    </x-input.group>

                    <x-input.group label="Port">
                        <x-input.text
                            name="smtp_port"
                            :value="old('smtp_port', config('mail.mailers.smtp.port'))"
                        ></x-input.text>
                    </x-input.group>

                    <x-input.group label="Username">
                        <x-input.text
                            name="smtp_username"
                            :value="old('smtp_username', config('mail.mailers.smtp.username'))"
                        ></x-input.text>
                    </x-input.group>

                    <x-input.group label="Password">
                        <x-input.password
                            name="smtp_password"
                            :value="old('smtp_password', config('mail.mailers.smtp.password'))"
                        ></x-input.password>
                    </x-input.group>

                    <x-input.group label="Encryption">
                        <x-input.select name="smtp_encryption">
                            <option value="" @selected(blank(config('mail.mailers.smtp.encryption')))>
                                No encryption
                            </option>
                            <option value="tls" @selected(config('mail.mailers.smtp.encryption') === 'tls')>
                                TLS
                            </option>
                        </x-input.select>
                    </x-input.group>
                </div>

                <div class="space-y-8" x-show="mailer === 'mailgun'" x-cloak>
                    <x-input.group label="Domain">
                        <x-input.text name="mailgun_domain" :value="config('services.mailgun.domain')"></x-input.text>
                    </x-input.group>

                    <x-input.group label="Secret">
                        <x-input.password
                            name="mailgun_secret"
                            :value="config('services.mailgun.secret')"
                        ></x-input.password>
                    </x-input.group>

                    <x-input.group label="Endpoint">
                        <x-input.text
                            name="mailgun_endpoint"
                            :value="config('services.mailgun.endpoint')"
                        ></x-input.text>
                    </x-input.group>
                </div>

                <div class="space-y-8" x-show="mailer === 'postmark'" x-cloak>
                    <x-input.group label="Token">
                        <x-input.text name="postmark_token" :value="config('services.postmark.token')"></x-input.text>
                    </x-input.group>
                </div>

                <div class="space-y-8" x-show="mailer === 'mailersend'" x-cloak>
                    <x-input.group label="API key">
                        <x-input.text
                            name="mailersend_api_key"
                            :value="config('services.postmark.token')"
                        ></x-input.text>
                    </x-input.group>
                </div>

                <div class="space-y-8" x-show="mailer === 'ses'" x-cloak>
                    <x-input.group label="AWS access key ID">
                        <x-input.text name="aws_access_key_id" :value="config('services.ses.key')"></x-input.text>
                    </x-input.group>

                    <x-input.group label="AWS secret access key">
                        <x-input.password
                            name="aws_secret_access_key"
                            :value="config('services.ses.secret')"
                        ></x-input.password>
                    </x-input.group>

                    <x-input.group label="AWS default region">
                        <x-input.text name="aws_default_region" :value="config('services.ses.region')"></x-input.text>
                    </x-input.group>
                </div>
            </x-form.section>

            <x-form.footer>
                <x-button.filled type="submit" form="email" color="primary">Update</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
