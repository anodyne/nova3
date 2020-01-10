<?php

namespace Nova\Users\Mail;

use Nova\Users\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

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
