@extends($meta->template)

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button x-on:click="$dispatch('toggle-spotlight')" color="neutral">
                        <x-icon name="search" size="sm"></x-icon>
                        Find a setting
                    </x-button>
                </div>
            </x-slot>
        </x-page-header>

        <x-form :action="route('admin.settings.email.update')" method="PUT">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Subject prefix" id="subject_prefix" name="subject_prefix">
                        <x-input.text
                            :value="old('subject_prefix', $settings->subjectPrefix)"
                            placeholder="[USS Nova]"
                        ></x-input.text>
                    </x-fieldset.field>

                    <x-fieldset.field label="Reply to email address" id="reply_to" name="reply_to">
                        <x-input.text
                            :value="old('reply_to', $settings->replyTo)"
                            placeholder="reply-to-nova@example.com"
                        ></x-input.text>
                    </x-fieldset.field>

                    <x-fieldset.field label="Global from email address" id="from_address" name="from_address">
                        <x-input.text :value="config('mail.from.address')"></x-input.text>
                    </x-fieldset.field>

                    <x-fieldset.field label="Global from email name" id="from_name" name="from_name">
                        <x-input.text :value="config('mail.from.name')"></x-input.text>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="image"></x-icon>
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
                    <x-icon name="settings"></x-icon>
                    <x-fieldset.legend>Configuration</x-fieldset.legend>
                    <x-fieldset.description>
                        Set your email configuration values and they’ll be written to the configuration file for you.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group x-data="{ mailer: '{{ config('mail.default') }}' }" constrained>
                    <x-fieldset.field label="Mailer" id="mailer" name="mailer">
                        <x-select x-model="mailer">
                            <option value="sendmail">Sendmail</option>
                            <option value="smtp">SMTP</option>
                            <option value="mailgun">Mailgun</option>
                            <option value="postmark">Postmark</option>
                            <option value="ses">Amazon SES</option>
                            <option value="mailersend">MailerSend</option>
                        </x-select>

                        <x-slot name="description">
                            <span x-show="mailer === 'sendmail'" x-cloak>
                                While sendmail is the default mailer, we strongly recommend using a third-party SMTP
                                transactional email service to handle your email
                            </span>
                        </x-slot>
                    </x-fieldset.field>

                    <div x-show="mailer === 'sendmail'" x-cloak>
                        <x-fieldset.field
                            label="Sendmail path"
                            description="While this is a sensible default for most servers, you may need to contact your web host to verify this is the correct configuration for Sendmail if your email isn't being delivered"
                            id="sendmail_path"
                            name="sendmail_path"
                        >
                            <x-input.text
                                :value="old('sendmail_path', config('mail.mailers.sendmail.path'))"
                            ></x-input.text>
                        </x-fieldset.field>
                    </div>

                    <div class="space-y-8" x-show="mailer === 'smtp'" x-cloak>
                        <x-fieldset.field label="Host" id="smtp_host" name="smtp_host">
                            <x-input.text :value="old('smtp_host', config('mail.mailers.smtp.host'))"></x-input.text>
                        </x-fieldset.field>

                        <x-fieldset.field label="Port" id="smtp_port" name="smtp_port">
                            <x-input.text :value="old('smtp_port', config('mail.mailers.smtp.port'))"></x-input.text>
                        </x-fieldset.field>

                        <x-fieldset.field label="Username" id="smtp_username" name="smtp_username">
                            <x-input.text
                                :value="old('smtp_username', config('mail.mailers.smtp.username'))"
                            ></x-input.text>
                        </x-fieldset.field>

                        <x-fieldset.field label="Password" id="smtp_password" name="smtp_password">
                            <x-input.password
                                :value="old('smtp_password', config('mail.mailers.smtp.password'))"
                            ></x-input.password>
                        </x-fieldset.field>

                        <x-fieldset.field label="Encryption" id="smtp_encryption" name="smtp_encryption">
                            <x-select>
                                <option value="" @selected(blank(config('mail.mailers.smtp.encryption')))>
                                    No encryption
                                </option>
                                <option value="tls" @selected(config('mail.mailers.smtp.encryption') === 'tls')>
                                    TLS
                                </option>
                            </x-select>
                        </x-fieldset.field>
                    </div>

                    <div class="space-y-8" x-show="mailer === 'mailgun'" x-cloak>
                        <x-fieldset.field label="Domain" id="mailgun_domain" name="mailgun_domain">
                            <x-input.text :value="config('services.mailgun.domain')"></x-input.text>
                        </x-fieldset.field>

                        <x-fieldset.field label="Secret" id="mailgun_secret" name="mailgun_secret">
                            <x-input.password :value="config('services.mailgun.secret')"></x-input.password>
                        </x-fieldset.field>

                        <x-fieldset.field label="Endpoint" id="mailgun_endpoint" name="mailgun_endpoint">
                            <x-input.text :value="config('services.mailgun.endpoint')"></x-input.text>
                        </x-fieldset.field>
                    </div>

                    <div class="space-y-8" x-show="mailer === 'postmark'" x-cloak>
                        <x-fieldset.field label="Token" id="postmark_token" name="postmark_token">
                            <x-input.text :value="config('services.postmark.token')"></x-input.text>
                        </x-fieldset.field>
                    </div>

                    <div class="space-y-8" x-show="mailer === 'mailersend'" x-cloak>
                        <x-fieldset.field label="API key" id="mailersend_api_key" name="mailersend_api_key">
                            <x-input.text :value="config('services.postmark.token')"></x-input.text>
                        </x-fieldset.field>
                    </div>

                    <div class="space-y-8" x-show="mailer === 'ses'" x-cloak>
                        <x-fieldset.field label="AWS access key ID" id="aws_access_key_id" name="aws_access_key_id">
                            <x-input.text :value="config('services.ses.key')"></x-input.text>
                        </x-fieldset.field>

                        <x-fieldset.field
                            label="AWS secret access key"
                            id="aws_secret_access_key"
                            name="aws_secret_access_key"
                        >
                            <x-input.password :value="config('services.ses.secret')"></x-input.password>
                        </x-fieldset.field>

                        <x-fieldset.field label="AWS default region" id="aws_default_region" name="aws_default_region">
                            <x-input.text :value="config('services.ses.region')"></x-input.text>
                        </x-fieldset.field>
                    </div>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
@endsection
