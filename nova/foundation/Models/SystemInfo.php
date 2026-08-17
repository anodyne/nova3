<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Carbon\CarbonImmutable;

/**
 * @property int $id
 * @property string $version
 * @property string|null $anodyne_game_id
 * @property CarbonImmutable|null $install_date
 * @property CarbonImmutable|null $last_update
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo whereAnodyneGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo whereInstallDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo whereLastUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo whereVersion($value)
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
