<?php

declare(strict_types=1);

namespace Nova\Setup\Models\Legacy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mission extends Model
{
    public $timestamps = false;

    protected $connection = 'nova2';

    protected $table = 'missions';

    protected $primaryKey = 'mission_id';

    /** @return BelongsTo<MissionGroup, $this> */
    public function missionGroup(): BelongsTo
    {
        return $this->belongsTo(MissionGroup::class, 'misgroup_id', 'mission_group');
    }

    /** @return HasMany<Post, $this> */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'post_mission', 'mission_id');
    }
}
