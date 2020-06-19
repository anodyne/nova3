<?php

namespace Nova\Ranks\Models;

use Nova\Ranks\Events;
use Illuminate\Database\Eloquent\Model;
use Nova\Ranks\Models\Builders\RankGroupBuilder;
use Spatie\Activitylog\Traits\LogsActivity;

class RankGroup extends Model
{
    use LogsActivity;

    protected static $logFillable = true;

    protected static $logName = 'admin';

    protected $dispatchesEvents = [
        'created' => Events\RankGroupCreated::class,
        'updated' => Events\RankGroupUpdated::class,
        'deleted' => Events\RankGroupDeleted::class,
    ];

    protected $fillable = ['name'];

    protected $table = 'rank_groups';

    /**
     * Set the description for logging.
     *
     * @param  string  $eventName
     *
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return ":subject.name rank group was {$eventName}";
    }

    /**
     * Use a custom Eloquent builder.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return RankGroupBuilder
     */
    public function newEloquentBuilder($query): RankGroupBuilder
    {
        return new RankGroupBuilder($query);
    }
}
