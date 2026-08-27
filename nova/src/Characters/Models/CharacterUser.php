<?php

declare(strict_types=1);

namespace Nova\Characters\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Nova\Foundation\Models\Concerns\HasTableHelpers;

/**
 * @mixin IdeHelperCharacterUser
 */
class CharacterUser extends Pivot
{
    use HasTableHelpers;
    use HasUuids;

    protected $attributes = [
        'primary' => false,
    ];

    protected $table = 'character_user';

    /**
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'primary' => 'boolean',
        ];
    }
}
