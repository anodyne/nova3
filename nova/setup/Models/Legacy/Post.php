<?php

declare(strict_types=1);

namespace Nova\Setup\Models\Legacy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    public $timestamps = false;

    protected $connection = 'nova2';

    protected $table = 'posts';

    protected $primaryKey = 'post_id';

    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class, 'mission_id', 'post_mission');
    }
}
