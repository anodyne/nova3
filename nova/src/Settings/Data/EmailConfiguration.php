<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Bag\Attributes\MapInputName;
use Bag\Attributes\StripExtraParameters;
use Bag\Bag;
use Bag\Mappers\SnakeCase;
use Nova\Settings\Enums\Mailer;

/**
 * @method static static from(?string $mailer, ?string $fromAddress, ?string $fromName, ?string $sendmailPath, ?string $smtpHost, ?string $smtpPort, ?string $smtpUsername, ?string $smtpPassword, ?string $smtpEncryption, ?string $mailgunDomain, ?string $mailgunSecret, ?string $mailgunEndpoint, ?string $mailersendApiKey, ?string $postmarkToken, ?string $awsAccessKeyId, ?string $awsSecretAccessKey, ?string $awsDefaultRegion)
 */
#[MapInputName(SnakeCase::class)]
#[StripExtraParameters]
readonly class EmailConfiguration extends Bag
{
    public function __construct(
        public Mailer $mailer,

        public ?string $fromAddress,
        public ?string $fromName,

        public ?string $sendmailPath,

        public ?string $smtpHost,
        public ?string $smtpPort,
        public ?string $smtpUsername,
        public ?string $smtpPassword,
        public ?string $smtpEncryption,

        public ?string $mailgunDomain,
        public ?string $mailgunSecret,
        public ?string $mailgunEndpoint,

        public ?string $mailersendApiKey,

        public ?string $postmarkToken,

        public ?string $awsAccessKeyId,
        public ?string $awsSecretAccessKey,
        public ?string $awsDefaultRegion,

        public ?string $resendApiKey
    ) {}

    public function getEnvVariables(): array
    {
        return match ($this->mailer) {
            Mailer::Sendmail => [
                'MAIL_SENDMAIL_PATH' => $this->sendmailPath,
            ],
            Mailer::Smtp => [
                'MAIL_HOST' => $this->smtpHost,
                'MAIL_PORT' => $this->smtpPort,
                'MAIL_USERNAME' => $this->smtpUsername,
                'MAIL_PASSWORD' => $this->smtpPassword,
                'MAIL_ENCRYPTION' => $this->smtpEncryption,
            ],
            Mailer::Mailgun => [
                'MAILGUN_DOMAIN' => $this->mailgunDomain,
                'MAILGUN_SECRET' => $this->mailgunSecret,
                'MAILGUN_ENDPOINT' => $this->mailgunEndpoint,
            ],
            Mailer::MailerSend => [
                'MAILERSEND_API_KEY' => $this->mailersendApiKey,
            ],
            Mailer::Resend => [
                'RESEND_API_KEY' => $this->resendApiKey,
            ],
            Mailer::Postmark => [
                'POSTMARK_TOKEN' => $this->postmarkToken,
            ],
            Mailer::Ses => [
                'AWS_ACCESS_KEY_ID' => $this->awsAccessKeyId,
                'AWS_SECRET_ACCESS_KEY' => $this->awsSecretAccessKey,
                'AWS_DEFAULT_REGION' => $this->awsDefaultRegion,
            ],
            default => [],
        };
    }
}
