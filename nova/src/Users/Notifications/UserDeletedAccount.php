<?php

declare(strict_types=1);

namespace Nova\Users\Notifications;

use Illuminate\Contracts\Mail\Mailable;
use Nova\Foundation\Notifications\PreferenceBasedNotification;
use Nova\Users\Mail\SendUserDeletedAccount;
use Nova\Users\Models\User;

class UserDeletedAccount extends PreferenceBasedNotification
{
    protected string $key = 'user-deleted-account';

    public function __construct(
        public User $user
    ) {
    }

    public function toArray(object $notifiable): array
    {
        return [
            'user_name' => $this->user->name,
        ];
    }

    public function mailable(): Mailable
    {
        return new SendUserDeletedAccount(
            user: $this->user
        );
    }
}
