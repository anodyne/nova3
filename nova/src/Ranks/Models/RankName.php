<?php

namespace Nova\Ranks\Models;

use Nova\Ranks\Events;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Nova\Ranks\Models\Builders\RankNameBuilder;

class RankName extends Model
{
    use LogsActivity;

    protected static $logFillable = true;

    protected static $logName = 'admin';

    protected $dispatchesEvents = [
        'created' => Events\RankNameCreated::class,
        'updated' => Events\RankNameUpdated::class,
        'deleted' => Events\RankNameDeleted::class,
    ];

    protected $fillable = ['name', 'sort'];

    protected $table = 'rank_names';

    public function ranks()
    {
        return $this->hasMany(RankItem::class, 'name_id')
            ->orderBy('sort', 'asc');
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
     * @return RankNameBuilder
     */
    public function newEloquentBuilder($query): RankNameBuilder
    {
        return new RankNameBuilder($query);
    }
}
