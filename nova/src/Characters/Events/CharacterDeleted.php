<?php

declare(strict_types=1);

namespace Nova\Characters\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Characters\Models\Character;

class CharacterDeleted
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Character $character
    ) {}
}
