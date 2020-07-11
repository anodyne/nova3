<?php

namespace Nova\Departments\Models;

use Nova\Departments\Events;
use Nova\Characters\Models\Character;
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
        'deleted' => Events\PositionDeleted::class,
        'updated' => Events\PositionUpdated::class,
    ];

    protected $fillable = [
        'name', 'description', 'sort', 'active', 'available', 'department_id',
    ];

    protected $table = 'positions';

    public function characters()
    {
        return $this->belongsToMany(Character::class)->withPivot('primary');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return ":subject.name position was {$eventName}";
    }

    public function newEloquentBuilder($query): PositionBuilder
    {
        return new PositionBuilder($query);
    }
}
