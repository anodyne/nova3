<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Carbon\CarbonImmutable;
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory whereStatusableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory whereStatusableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory whereUpdatedAt($value)
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
