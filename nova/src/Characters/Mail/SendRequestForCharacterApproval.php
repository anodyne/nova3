<?php

declare(strict_types=1);

namespace Nova\Characters\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

class SendRequestForCharacterApproval extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Character $character,
        public User $creatingUser
    ) {
    }

    public function build()
    {
        return $this->markdown('emails.characters.character-requires-approval')
            // ->to($this->user->email)
            ->subject('New Character Created');
    }
}
