<?php

declare(strict_types=1);

namespace Nova\Departments\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nova\Characters\Models\Character;
use Nova\Departments\Events;
use Nova\Departments\Models\Builders\PositionBuilder;
use Nova\Departments\Models\States\Positions\PositionStatus;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\ModelStates\HasStates;

class Position extends Model
{
    use HasFactory;
    use HasStates;
    use LogsActivity;

    protected $casts = [
        'sort' => 'integer',
        'status' => PositionStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\PositionCreated::class,
        'deleted' => Events\PositionDeleted::class,
        'updated' => Events\PositionUpdated::class,
    ];

    protected $fillable = [
        'name', 'description', 'sort', 'available', 'department_id', 'status',
    ];

    protected $table = 'positions';

    public function activeCharacters()
    {
        return $this->characters()->whereActive();
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class)->withPivot('primary');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName('admin')
            ->setDescriptionForEvent(
                fn (string $eventName) => ":subject.name position was {$eventName}"
            );
    }

    public function newEloquentBuilder($query): PositionBuilder
    {
        return new PositionBuilder($query);
    }
}
