<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property string $version
 * @property string|null $anodyne_game_id
 * @property CarbonImmutable|null $install_date
 * @property CarbonImmutable|null $last_update
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 *
 * @method static Builder<static>|SystemInfo newModelQuery()
 * @method static Builder<static>|SystemInfo newQuery()
 * @method static Builder<static>|SystemInfo query()
 * @method static Builder<static>|SystemInfo whereAnodyneGameId($value)
 * @method static Builder<static>|SystemInfo whereCreatedAt($value)
 * @method static Builder<static>|SystemInfo whereId($value)
 * @method static Builder<static>|SystemInfo whereInstallDate($value)
 * @method static Builder<static>|SystemInfo whereLastUpdate($value)
 * @method static Builder<static>|SystemInfo whereUpdatedAt($value)
 * @method static Builder<static>|SystemInfo whereVersion($value)
 *
 * @mixin \Eloquent
 */
class SystemInfo extends Model
{
    protected $casts = [
        'install_date' => 'datetime',
        'last_update' => 'datetime',
    ];

    protected $fillable = [
        'version', 'install_date', 'last_update', 'anodyne_game_id',
    ];

    protected $table = 'system_info';
}
