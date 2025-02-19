<?php

declare(strict_types=1);

namespace Nova\Settings\Enums;

use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;

enum Mailer: string implements HasDescription, HasLabel
{
    case Log = 'log';

    case Sendmail = 'sendmail';

    case Smtp = 'smtp';

    case Ses = 'ses';

    case MailerSend = 'mailersend';

    case Mailgun = 'mailgun';

    case Postmark = 'postmark';

    case Resend = 'resend';

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Log => 'This is for development purposes only. Email will be printed to the log files rather than sent to the recipient.',

            self::Sendmail => 'While Sendmail is the default mailer, we strongly recommend using a third-party SMTP transactional email service to handle your email.',

            default => null,
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Smtp => 'SMTP',
            self::Ses => 'Amazon SES',
            self::MailerSend => 'MailerSend',
            default => ucfirst($this->value),
        };
    }
}
