<?php

namespace Nova\Departments\Models;

use Nova\Departments\Events;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Nova\Departments\Models\Builders\DepartmentBuilder;

class Department extends Model
{
    use LogsActivity;

    protected static $logFillable = true;

    protected static $logName = 'admin';

    protected $casts = [
        'active' => 'boolean',
        'sort' => 'integer',
    ];

    protected $dispatchesEvents = [
        'created' => Events\DepartmentCreated::class,
        'updated' => Events\DepartmentUpdated::class,
        'deleted' => Events\DepartmentDeleted::class,
    ];

    protected $fillable = ['name', 'description', 'sort', 'active'];

    protected $table = 'departments';

    public function positions()
    {
        return $this->hasMany(Position::class)->orderBy('sort', 'asc');
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
        return ":subject.name department was {$eventName}";
    }

    /**
     * Use a custom Eloquent builder.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return DepartmentBuilder
     */
    public function newEloquentBuilder($query): DepartmentBuilder
    {
        return new DepartmentBuilder($query);
    }
}
