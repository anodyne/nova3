<?php

declare(strict_types=1);

namespace Nova\Characters\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Nova\Foundation\Models\Concerns\HasTableHelpers;

/**
 * @property int $id
 * @property int $character_id
 * @property int $user_id
 * @property bool $primary
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CharacterUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CharacterUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CharacterUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CharacterUser whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CharacterUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CharacterUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CharacterUser wherePrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CharacterUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CharacterUser whereUserId($value)
 * @mixin \Eloquent
 */
class CharacterUser extends Pivot
{
    use HasTableHelpers;

    protected $table = 'character_user';

    protected $casts = [
        'primary' => 'boolean',
    ];
}
