<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StatusHistory extends Model
{
    protected $table = 'status_history';

    protected $fillable = ['status', 'started_at', 'ended_at'];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function statusable(): MorphTo
    {
        return $this->morphTo();
    }
}
