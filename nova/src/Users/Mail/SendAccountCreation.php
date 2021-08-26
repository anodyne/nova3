<?php

declare(strict_types=1);

namespace Nova\Users\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Nova\Users\Models\User;

class SendAccountCreation extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * @var  User
     */
    public $user;

    /**
     * @var  string
     */
    public $password;

    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->markdown('emails.users.account-created')
            ->to($this->user->email)
            ->subject('User Account Created');
    }
}
