<?php

declare(strict_types=1);

namespace Nova\Characters\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Nova\Foundation\Models\Concerns\HasTableHelpers;

/**
 * @property int $id
 * @property int $character_id
 * @property int $position_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterPosition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterPosition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterPosition query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterPosition whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterPosition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterPosition wherePositionId($value)
 *
 * @mixin \Eloquent
 */
class CharacterPosition extends Pivot
{
    use HasTableHelpers;

    protected $table = 'character_position';
}
