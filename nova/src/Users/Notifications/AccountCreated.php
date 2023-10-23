<?php

declare(strict_types=1);

namespace Nova\Users\Notifications;

use Illuminate\Contracts\Mail\Mailable;
use Nova\Foundation\Notifications\PreferenceBasedNotification;
use Nova\Users\Mail\SendAccountCreation;

class AccountCreated extends PreferenceBasedNotification
{
    protected string $key = 'account-created';

    /**
     * @var  string
     */
    public $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function toMail(object $notifiable): Mailable
    {
        return new SendAccountCreation($notifiable, $this->password);
    }
}
