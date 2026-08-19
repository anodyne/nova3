<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $statusable_type
 * @property int $statusable_id
 * @property string $status
 * @property CarbonImmutable $started_at
 * @property CarbonImmutable|null $ended_at
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $statusable
 *
 * @method static Builder<static>|StatusHistory newModelQuery()
 * @method static Builder<static>|StatusHistory newQuery()
 * @method static Builder<static>|StatusHistory query()
 * @method static Builder<static>|StatusHistory whereCreatedAt($value)
 * @method static Builder<static>|StatusHistory whereEndedAt($value)
 * @method static Builder<static>|StatusHistory whereId($value)
 * @method static Builder<static>|StatusHistory whereStartedAt($value)
 * @method static Builder<static>|StatusHistory whereStatus($value)
 * @method static Builder<static>|StatusHistory whereStatusableId($value)
 * @method static Builder<static>|StatusHistory whereStatusableType($value)
 * @method static Builder<static>|StatusHistory whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class StatusHistory extends Model
{
    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    protected $fillable = ['status', 'started_at', 'ended_at'];

    protected $table = 'status_history';

    public function statusable(): MorphTo
    {
        return $this->morphTo();
    }
}
