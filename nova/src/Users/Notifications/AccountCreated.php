<?php

declare(strict_types=1);

namespace Nova\Users\Notifications;

use Illuminate\Contracts\Mail\Mailable;
use Nova\Foundation\Notifications\PreferenceBasedNotification;
use Nova\Users\Mail\SendAccountCreation;
use Nova\Users\Models\User;

class AccountCreated extends PreferenceBasedNotification
{
    protected string $key = 'account-created';

    public function __construct(
        public User $user,
        public string $password
    ) {
    }

    public function toArray(object $notifiable): array
    {
        return [
            'password' => $this->password,
        ];
    }

    public function mailable(): Mailable
    {
        return new SendAccountCreation(
            user: $this->user,
            password: $this->password
        );
    }
}
