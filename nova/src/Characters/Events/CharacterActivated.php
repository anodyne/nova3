<?php

namespace Nova\Characters\Events;

use Nova\Characters\Models\Character;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class CharacterActivated
{
    use Dispatchable;
    use SerializesModels;

    public $character;

    public function __construct(Character $character)
    {
        $this->character = $character;
    }
}
