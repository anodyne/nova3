<?php

declare(strict_types=1);

namespace Nova\Characters\Notifications;

use Illuminate\Contracts\Mail\Mailable;
use Nova\Characters\Mail\SendRequestForCharacterApproval;
use Nova\Characters\Models\Character;
use Nova\Foundation\Notifications\PreferenceBasedNotification;
use Nova\Users\Models\User;

class CharacterRequiresApproval extends PreferenceBasedNotification
{
    protected string $key = 'character-requires-approval';

    public function __construct(
        public Character $character,
        public User $user
    ) {}

    public function toArray(object $notifiable): array
    {
        return [
            'character_id' => $this->character->id,
            'character_name' => $this->character->name,
            'position_count' => $this->character->positions->count(),
            'position_names' => $this->character->positions?->pluck('name')?->join(',', ', and '),
            'rank_name' => $this->character->rank?->name->name,
            'creator_name' => $this->user->name,
        ];
    }

    public function mailable(): Mailable
    {
        return new SendRequestForCharacterApproval(
            character: $this->character,
            creatingUser: $this->user
        );
    }
}
