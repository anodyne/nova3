<?php

declare(strict_types=1);

namespace Nova\Ranks\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nova\Ranks\Events;
use Nova\Ranks\Models\Builders\RankGroupBuilder;
use Nova\Ranks\Models\States\Groups\RankGroupStatus;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\ModelStates\HasStates;

class RankGroup extends Model
{
    use HasFactory;
    use HasStates;
    use LogsActivity;

    protected static $logFillable = true;

    protected static $logName = 'admin';

    protected $casts = [
        'sort' => 'integer',
        'status' => RankGroupStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\RankGroupCreated::class,
        'updated' => Events\RankGroupUpdated::class,
        'deleted' => Events\RankGroupDeleted::class,
    ];

    protected $fillable = ['name', 'sort', 'status'];

    protected $table = 'rank_groups';

    public function ranks()
    {
        return $this->hasMany(RankItem::class, 'group_id')
            ->orderBy('sort', 'asc');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName('admin')
            ->setDescriptionForEvent(
                fn (string $eventName) => ":subject.name rank group was {$eventName}"
            );
    }

    /**
     * Use a custom Eloquent builder.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     */
    public function newEloquentBuilder($query): RankGroupBuilder
    {
        return new RankGroupBuilder($query);
    }
}
