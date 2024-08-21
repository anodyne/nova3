<?php

declare(strict_types=1);

namespace Nova\PublicSite\Notifications;

use Illuminate\Contracts\Mail\Mailable;
use Nova\Foundation\Notifications\PreferenceBasedNotification;
use Nova\PublicSite\Mail\SendSiteContactMessage;

class SiteContactMessage extends PreferenceBasedNotification
{
    protected string $key = 'site-contact-message';

    public function __construct(
        public string $name,
        public string $email,
        public string $subjectLine,
        public string $message
    ) {}

    public function toArray(object $notifiable): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subjectLine,
            'message' => $this->message,
        ];
    }

    public function mailable(): Mailable
    {
        return new SendSiteContactMessage(
            name: $this->name,
            email: $this->email,
            subjectLine: $this->subjectLine,
            message: $this->message,
        );
    }
}
