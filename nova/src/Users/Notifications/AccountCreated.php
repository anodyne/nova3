<?php

declare(strict_types=1);

namespace Nova\Users\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Nova\Users\Mail\SendAccountCreation;

class AccountCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var  string
     */
    public $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return new SendAccountCreation($notifiable, $this->password);
    }
}
