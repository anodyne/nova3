<?php

declare(strict_types=1);

namespace Nova\Characters\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Characters\Models\Character;

class CharacterDeletedByAdmin
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Character $character
    ) {}
}
