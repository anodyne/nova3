<?php

namespace Nova\Ranks\Models;

use Nova\Ranks\Events;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Nova\Ranks\Models\Builders\RankItemBuilder;

class RankItem extends Model
{
    use LogsActivity;

    protected static $logFillable = true;

    protected static $logName = 'admin';

    protected $casts = [
        'sort' => 'integer',
    ];

    protected $dispatchesEvents = [
        'created' => Events\RankItemCreated::class,
        'updated' => Events\RankItemUpdated::class,
        'deleted' => Events\RankItemDeleted::class,
    ];

    protected $fillable = [
        'base_image', 'overlay_image', 'group_id', 'name_id', 'sort'
    ];

    protected $table = 'rank_items';

    public function group()
    {
        return $this->belongsTo(RankGroup::class, 'group_id');
    }

    public function name()
    {
        return $this->belongsTo(RankName::class, 'name_id');
    }

    /**
     * Set the description for logging.
     *
     * @param  string  $eventName
     *
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return ":subject.name rank name was {$eventName}";
    }

    /**
     * Use a custom Eloquent builder.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return RankItemBuilder
     */
    public function newEloquentBuilder($query): RankItemBuilder
    {
        return new RankItemBuilder($query);
    }
}
