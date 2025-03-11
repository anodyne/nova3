<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

class SystemInfo extends Model
{
    protected $table = 'system_info';

    protected $fillable = [
        'version', 'install_date', 'last_update', 'anodyne_game_id',
    ];

    protected $casts = [
        'install_date' => 'datetime',
        'last_update' => 'datetime',
    ];
}
