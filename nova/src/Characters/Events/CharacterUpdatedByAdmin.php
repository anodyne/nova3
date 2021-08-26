<?php

declare(strict_types=1);

namespace Nova\Characters\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Characters\Models\Character;

class CharacterUpdatedByAdmin
{
    use Dispatchable;
    use SerializesModels;

    public $character;

    public function __construct(Character $character)
    {
        $this->character = $character;
    }
}
