<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Nova\Settings\Actions\UpdateEmail;
use Nova\Settings\Actions\UpdateSettings;
use Nova\Settings\Data\Email;
use Nova\Settings\Data\EmailConfiguration;
use Nova\Settings\Enums\Mailer;

class EmailSettingsForm extends Form
{
    public Mailer $mailer;

    public ?string $imagePath;

    #[Validate('required')]
    public string $fromAddress;

    #[Validate('required')]
    public string $fromName;

    public ?string $subjectPrefix;

    public ?string $replyTo;

    public ?string $sendmailPath;

    public ?string $mailgunDomain;

    public ?string $mailgunSecret;

    public ?string $mailgunEndpoint;

    public ?string $postmarkToken;

    public ?string $mailersendApiKey;

    public ?string $resendApiKey;

    public ?string $awsAccessKeyId;

    public ?string $awsSecretAccessKey;

    public ?string $awsDefaultRegion;

    public ?string $smtpHost;

    public ?string $smtpPort;

    public ?string $smtpUsername;

    public ?string $smtpPassword;

    public ?string $smtpEncryption;

    public function save(): void
    {
        $this->validate();

        DB::transaction(function () {
            UpdateSettings::run('email', $data = Email::from($this->all()));

            UpdateEmail::run($data, EmailConfiguration::from($this->all()));
        });
    }

    public function setEmailSettings(): void
    {
        $settings = settings('email');

        $this->mailer = Mailer::tryFrom(config('mail.default')) ?? Mailer::Sendmail;
        $this->fromAddress = config('mail.from.address');
        $this->fromName = config('mail.from.name');
        $this->subjectPrefix = $settings->subjectPrefix;
        $this->replyTo = $settings->replyTo;
        $this->imagePath = $settings->imagePath;

        $this->sendmailPath = config('mail.mailers.sendmail.path', '/usr/sbin/sendmail -bs -i');

        $this->mailgunDomain = config('services.mailgun.domain');
        $this->mailgunSecret = config('services.mailgun.secret');
        $this->mailgunEndpoint = config('services.mailgun.endpoint');

        $this->postmarkToken = config('services.postmark.token');

        $this->mailersendApiKey = config('mailersend-driver.api_key');

        $this->resendApiKey = config('services.resend.key');

        $this->awsAccessKeyId = config('services.ses.key');
        $this->awsSecretAccessKey = config('services.ses.secret');
        $this->awsDefaultRegion = config('services.ses.region');

        $this->smtpHost = config('mail.mailers.smtp.host');
        $this->smtpPort = config('mail.mailers.smtp.port');
        $this->smtpUsername = config('mail.mailers.smtp.username');
        $this->smtpPassword = config('mail.mailers.smtp.password');
        $this->smtpEncryption = config('mail.mailers.smtp.encryption') ?? '';
    }
}
