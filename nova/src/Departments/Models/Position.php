<?php

declare(strict_types=1);

namespace Nova\Departments\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nova\Characters\Models\Character;
use Nova\Departments\Enums\PositionStatus;
use Nova\Departments\Events;
use Nova\Departments\Models\Builders\PositionBuilder;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Position extends Model implements Sortable
{
    use HasFactory;
    use LogsActivity;
    use SortableTrait;

    protected $table = 'positions';

    protected $fillable = [
        'name', 'description', 'order_column', 'available', 'department_id', 'status',
    ];

    protected $casts = [
        'order_column' => 'integer',
        'status' => PositionStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\PositionCreated::class,
        'deleted' => Events\PositionDeleted::class,
        'updated' => Events\PositionUpdated::class,
    ];

    public function activeCharacters()
    {
        return $this->characters()->active();
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()->logFillable();

        if (app('impersonate')->isImpersonating()) {
            return $logOptions->useLogName('impersonation')
                ->setDescriptionForEvent(
                    fn (string $eventName): string => ":subject.name position was {$eventName} during impersonation by ".app('impersonate')->getImpersonator()->name
                );
        }

        return $logOptions
            ->setDescriptionForEvent(
                fn (string $eventName): string => ":subject.name position was {$eventName}"
            );
    }

    public function buildSortQuery(): Builder
    {
        return static::query()->where('department_id', $this->department_id);
    }

    public function newEloquentBuilder($query): PositionBuilder
    {
        return new PositionBuilder($query);
    }
}
