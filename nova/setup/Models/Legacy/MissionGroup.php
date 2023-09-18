<?php

declare(strict_types=1);

namespace Nova\Setup\Models\Legacy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MissionGroup extends Model
{
    public $timestamps = false;

    protected $connection = 'nova2';

    protected $table = 'mission_groups';

    protected $primaryKey = 'misgroup_id';

    public function missions(): HasMany
    {
        return $this->hasMany(Mission::class, 'mission_group', 'misgroup_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'post_mission', 'post_id');
    }
}
