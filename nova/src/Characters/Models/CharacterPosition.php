<?php

declare(strict_types=1);

namespace Nova\Characters\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Nova\Foundation\Models\Concerns\HasTableHelpers;

/**
 * @mixin IdeHelperCharacterPosition
 */
class CharacterPosition extends Pivot
{
    use HasTableHelpers;
    use HasUuids;

    protected $table = 'character_position';
}
