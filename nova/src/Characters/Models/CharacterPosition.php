<?php

declare(strict_types=1);

namespace Nova\Characters\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Nova\Foundation\Models\Concerns\HasTableHelpers;

class CharacterPosition extends Pivot
{
    use HasTableHelpers;

    protected $table = 'character_position';
}
