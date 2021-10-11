<?php

declare(strict_types=1);

namespace Nova\Characters\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Nova\Characters\Models\Character;

class CharacterNeedsApproval extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Character $character
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
        //
    }
}
