<?php

declare(strict_types=1);

namespace Nova\Characters\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notification;
use Nova\Characters\Mail\SendRequestForCharacterApproval;
use Nova\Characters\Models\Character;
use Nova\Foundation\Concerns\DelayedConditionalEmail;
use Nova\Users\Models\User;

class CharacterRequiresApproval extends Notification implements ShouldQueue
{
    use DelayedConditionalEmail;
    use Queueable;

    public function __construct(
        public Character $character,
        public User $user
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'character_id' => $this->character->id,
            'character_name' => $this->character->name,
            'position_count' => $this->character->positions->count(),
            'position_names' => $this->character->positions?->pluck('name')?->join(',', ', and '),
            'rank_name' => $this->character->rank?->name->name,
        ];
    }

    public function toMail(object $notifiable): Mailable
    {
        $mailable = new SendRequestForCharacterApproval(
            character: $this->character,
            creatingUser: $this->user
        );

        return $mailable->to($notifiable->email);
    }
}
