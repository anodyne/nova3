<?php

declare(strict_types=1);

namespace Nova\Characters\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notification;
use Nova\Characters\Mail\SendCharacterApproval;
use Nova\Characters\Models\Character;
use Nova\Foundation\Concerns\DelayedConditionalEmail;

class PendingCharacterApproved extends Notification implements ShouldQueue
{
    use DelayedConditionalEmail;
    use Queueable;

    public function __construct(
        public Character $character
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
            'rank_name' => $this->character?->rank?->name->name,
        ];
    }

    public function toMail(object $notifiable): Mailable
    {
        $mailable = new SendCharacterApproval(
            character: $this->character,
        );

        return $mailable->to($notifiable->email);
    }
}
