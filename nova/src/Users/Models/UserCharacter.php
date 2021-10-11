<?php

declare(strict_types=1);

namespace Nova\Users\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserCharacter extends Pivot
{
    protected $table = 'user_character';

    protected $casts = [
        'primary' => 'boolean',
    ];
}
