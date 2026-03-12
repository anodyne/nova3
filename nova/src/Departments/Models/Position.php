<?php

declare(strict_types=1);

namespace Nova\Departments\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\CharacterPosition;
use Nova\Characters\Models\CharacterUser;
use Nova\Departments\Events\PositionCreated;
use Nova\Departments\Events\PositionDeleted;
use Nova\Departments\Events\PositionUpdated;
use Nova\Departments\Models\Builders\PositionBuilder;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Models\Model;
use Nova\Users\Models\States\Status\Active;
use Nova\Users\Models\User;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

#[UseEloquentBuilder(PositionBuilder::class)]
class Position extends Model implements Sortable
{
    use HasFactory;
    use HasPrefixedId;
    use HasRelationships;
    use LogsActivity;
    use SortableTrait;

    protected $table = 'positions';

    protected $fillable = [
        'name', 'description', 'order_column', 'available', 'department_id', 'status', 'tags',
    ];

    protected $casts = [
        'available' => 'integer',
        'order_column' => 'integer',
        'status' => BasicStatus::class,
        'tags' => 'array',
    ];

    protected $dispatchesEvents = [
        'created' => PositionCreated::class,
        'deleted' => PositionDeleted::class,
        'updated' => PositionUpdated::class,
    ];

    public function activeCharacters(): BelongsToMany
    {
        return $this->characters()->active();
    }

    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class)
            ->using(CharacterPosition::class);
    }

    public function activeUsers(): HasManyDeep
    {
        return $this->users()
            ->where(User::column('status'), Active::$name);
    }

    public function users(): HasManyDeep
    {
        return $this->hasManyDeep(User::class, [
            CharacterPosition::table(),
            Character::class,
            CharacterUser::table(),
        ]);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function activeUsersCount(): Attribute
    {
        return Attribute::make(
            get: fn (): int => $this->activeUsers->unique()->count()
        );
    }

    public function tagsAsString(): Attribute
    {
        return Attribute::make(
            get: fn () => implode(', ', $this->tags ?? [])
        );
    }

    public function buildSortQuery(): Builder
    {
        return static::query()->where('department_id', $this->department_id);
    }
}
