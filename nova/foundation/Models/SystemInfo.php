<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

/**
 * @mixin IdeHelperSystemInfo
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
