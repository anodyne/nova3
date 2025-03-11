<?php

declare(strict_types=1);

namespace Nova\Characters\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Nova\Foundation\Models\Concerns\HasTableHelpers;

class CharacterUser extends Pivot
{
    use HasTableHelpers;

    protected $table = 'character_user';

    protected $casts = [
        'primary' => 'boolean',
    ];
}
