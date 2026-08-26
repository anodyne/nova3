<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin IdeHelperSystemInfo
 */
class SystemInfo extends Model
{
    protected $table = 'system_info';

    protected $fillable = [
        'version', 'last_update', 'anodyne_game_id',
    ];

    #[\Override]
    public function casts(): array
    {
        return [
            'install_date' => 'immutable_datetime',
            'last_update' => 'datetime',
        ];
    }

    /**
     * @return HasOne<ExternalChangelog, $this>
     */
    public function versionInfo(): HasOne
    {
        return $this->hasOne(ExternalChangelog::class, 'version', 'version');
    }
}
