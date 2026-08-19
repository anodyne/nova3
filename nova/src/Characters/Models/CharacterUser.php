<?php

declare(strict_types=1);

namespace Nova\Characters\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Nova\Foundation\Models\Concerns\HasTableHelpers;

/**
 * @property int $id
 * @property int $character_id
 * @property int $user_id
 * @property bool $primary
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 *
 * @method static Builder<static>|CharacterUser newModelQuery()
 * @method static Builder<static>|CharacterUser newQuery()
 * @method static Builder<static>|CharacterUser query()
 * @method static Builder<static>|CharacterUser whereCharacterId($value)
 * @method static Builder<static>|CharacterUser whereCreatedAt($value)
 * @method static Builder<static>|CharacterUser whereId($value)
 * @method static Builder<static>|CharacterUser wherePrimary($value)
 * @method static Builder<static>|CharacterUser whereUpdatedAt($value)
 * @method static Builder<static>|CharacterUser whereUserId($value)
 *
 * @mixin \Eloquent
 */
class CharacterUser extends Pivot
{
    use HasTableHelpers;

    protected $casts = [
        'primary' => 'boolean',
    ];

    protected $table = 'character_user';
}
