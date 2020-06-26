<?php

namespace Nova\Departments\Models;

use Nova\Departments\Events;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Nova\Departments\Models\Builders\PositionBuilder;

class Position extends Model
{
    use LogsActivity;

    protected static $logFillable = true;

    protected static $logName = 'admin';

    protected $casts = [
        'active' => 'boolean',
        'sort' => 'integer',
    ];

    protected $dispatchesEvents = [
        'created' => Events\PositionCreated::class,
        'updated' => Events\PositionUpdated::class,
        'deleted' => Events\PositionDeleted::class,
    ];

    protected $fillable = [
        'name', 'description', 'sort', 'active', 'available', 'department_id',
    ];

    protected $table = 'positions';

    public function department()
    {
        return $this->belongsTo(Department::class);
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
        return ":subject.name position was {$eventName}";
    }

    /**
     * Use a custom Eloquent builder.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return PositionBuilder
     */
    public function newEloquentBuilder($query): PositionBuilder
    {
        return new PositionBuilder($query);
    }
}
