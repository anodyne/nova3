<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin IdeHelperStatusHistory
 */
class StatusHistory extends Model
{
    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    protected $fillable = ['status', 'started_at', 'ended_at'];

    protected $table = 'status_history';

    /** @return MorphTo<EloquentModel, $this> */
    public function statusable(): MorphTo
    {
        return $this->morphTo();
    }
}
