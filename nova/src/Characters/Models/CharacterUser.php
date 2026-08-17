<?php

declare(strict_types=1);

namespace Nova\Characters\Models;

use Carbon\CarbonImmutable;
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser wherePrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser whereUserId($value)
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
