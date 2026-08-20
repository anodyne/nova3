<?php

declare(strict_types=1);

namespace Nova\Characters\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Nova\Foundation\Models\Concerns\HasTableHelpers;

/**
 * @mixin IdeHelperCharacterUser
 */
class CharacterUser extends Pivot
{
    use HasTableHelpers;

    protected $casts = [
        'primary' => 'boolean',
    ];

    protected $table = 'character_user';
}
