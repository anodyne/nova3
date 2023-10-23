<?php

declare(strict_types=1);

namespace Nova\Characters\Notifications;

use Illuminate\Mail\Mailable;
use Nova\Characters\Mail\SendCharacterDenial;
use Nova\Characters\Models\Character;
use Nova\Foundation\Notifications\PreferenceBasedNotification;

class PendingCharacterDenied extends PreferenceBasedNotification
{
    protected string $key = 'pending-character-denied';

    public function __construct(
        public Character $character
    ) {
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
        $mailable = new SendCharacterDenial(
            character: $this->character,
        );

        return $mailable->to($notifiable->email);
    }
}
