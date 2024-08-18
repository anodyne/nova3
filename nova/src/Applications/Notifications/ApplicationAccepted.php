<?php

declare(strict_types=1);

namespace Nova\Applications\Notifications;

use Illuminate\Contracts\Mail\Mailable;
use Nova\Applications\Mail\SendApplicationAcceptedMessage;
use Nova\Applications\Models\Application;
use Nova\Foundation\Notifications\PreferenceBasedNotification;

class ApplicationAccepted extends PreferenceBasedNotification
{
    protected string $key = 'application-accepted';

    public function __construct(
        protected Application $application
    ) {}

    public function toArray(object $notifiable): array
    {
        $this->application->load('character');

        return [
            'application_id' => $this->application->id,
            'character_name' => $this->application->character->name,
        ];
    }

    public function mailable(): Mailable
    {
        return new SendApplicationAcceptedMessage(
            application: $this->application
        );
    }
}
