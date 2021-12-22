<?php

declare(strict_types=1);

namespace Nova\Characters\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Nova\Characters\Mail\SendRequestForCharacterApproval;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

class CharacterRequiresApproval extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Character $character,
        public User $user
    ) {
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toArray($notifiable)
    {
        return [];
    }

    public function toMail($notifiable)
    {
        return new SendRequestForCharacterApproval(
            character: $this->character,
            creatingUser: $this->user
        );
    }
}
