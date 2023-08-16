<?php

declare(strict_types=1);

namespace Nova\Departments\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Nova\Characters\Models\Character;
use Nova\Departments\Enums\PositionStatus;
use Nova\Departments\Events;
use Nova\Departments\Models\Builders\PositionBuilder;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\User;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Position extends Model implements Sortable
{
    use HasFactory;
    use HasRelationships;
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

    public function activeCharacters(): BelongsToMany
    {
        return $this->characters()->active();
    }

    public function activeUsers(): HasManyDeep
    {
        return $this->users()->whereState('users.status', Active::class);
    }

    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class);
    }

    public function users(): HasManyDeep
    {
        return $this->hasManyDeep(
            User::class,
            ['character_position', Character::class, 'character_user']
        )->distinct();
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function buildSortQuery(): Builder
    {
        return static::query()->where('department_id', $this->department_id);
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

    public function newEloquentBuilder($query): PositionBuilder
    {
        return new PositionBuilder($query);
    }
}
