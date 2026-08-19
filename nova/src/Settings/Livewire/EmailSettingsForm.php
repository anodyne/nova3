<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Nova\Media\Actions\UploadImage;
use Nova\Media\Enums\ImageAction;
use Nova\Settings\Actions\UpdateEmail;
use Nova\Settings\Actions\UpdateSettings;
use Nova\Settings\Data\Email;
use Nova\Settings\Data\EmailConfiguration;
use Nova\Settings\Enums\Mailer;

class EmailSettingsForm extends Form
{
    public Mailer $mailer;

    #[Validate('required')]
    public string $fromAddress;

    #[Validate('required')]
    public string $fromName;

    public ?string $subjectPrefix = null;

    public ?string $replyTo = null;

    public ?string $sendmailPath = null;

    public ?string $mailgunDomain = null;

    public ?string $mailgunSecret = null;

    public ?string $mailgunEndpoint = null;

    public ?string $postmarkToken = null;

    public ?string $mailersendApiKey = null;

    public ?string $resendApiKey = null;

    public ?string $awsAccessKeyId = null;

    public ?string $awsSecretAccessKey = null;

    public ?string $awsDefaultRegion = null;

    public ?string $smtpHost = null;

    public ?string $smtpPort = null;

    public ?string $smtpUsername = null;

    public ?string $smtpPassword = null;

    public ?string $smtpEncryption = null;

    public ImageAction $imageAction;

    public ?string $imageTempPath = null;

    public function save(): void
    {
        $this->validate();

        DB::transaction(function (): void {
            UpdateSettings::run('email', $data = Email::from($this->except(['imageAction', 'imageTempPath'])));

            UpdateEmail::run($data, EmailConfiguration::from($this->except(['imageAction', 'imageTempPath'])));

            UploadImage::run(
                model: settings(),
                collection: 'logo-email',
                action: $this->imageAction,
                tempPath: $this->imageTempPath
            );
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
        $this->smtpPort = (string) config('mail.mailers.smtp.port');
        $this->smtpUsername = config('mail.mailers.smtp.username');
        $this->smtpPassword = config('mail.mailers.smtp.password');
        $this->smtpEncryption = config('mail.mailers.smtp.encryption') ?? '';

        $this->imageAction = ImageAction::Unchanged;
        $this->imageTempPath = null;
    }
}
