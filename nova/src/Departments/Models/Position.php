<?php

declare(strict_types=1);

namespace Nova\Departments\Models;

use Database\Factories\PositionFactory;
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

/**
 * @mixin IdeHelperPosition
 */
#[UseEloquentBuilder(PositionBuilder::class)]
class Position extends Model implements Sortable
{
    /** @use HasFactory<PositionFactory> */
    use HasFactory;

    use HasPrefixedId;
    use HasRelationships;
    use LogsActivity;
    use SortableTrait;

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

    protected $fillable = [
        'name', 'description', 'order_column', 'available', 'department_id', 'status', 'tags',
    ];

    protected $table = 'positions';

    /**
     * @return BelongsToMany<Character, $this, CharacterPosition, 'pivot'>
     */
    public function activeCharacters(): BelongsToMany
    {
        /** @var BelongsToMany<Character, $this, CharacterPosition, 'pivot'> $relation */
        $relation = $this->characters()
            ->whereState('status', \Nova\Characters\Models\States\Status\Active::class);

        return $relation;
    }

    /**
     * @return HasManyDeep<User, $this>
     */
    public function activeUsers(): HasManyDeep
    {
        return $this->users()
            ->where(User::column('status'), Active::$name);
    }

    /**
     * @return BelongsToMany<Character, $this, CharacterPosition, 'pivot'>
     */
    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class)
            ->using(CharacterPosition::class);
    }

    /**
     * @return BelongsTo<Department, $this>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return HasManyDeep<User, $this>
     */
    public function users(): HasManyDeep
    {
        return $this->hasManyDeep(User::class, [
            CharacterPosition::table(),
            Character::class,
            CharacterUser::table(),
        ]);
    }

    /**
     * @return Attribute<int, never>
     */
    public function activeUsersCount(): Attribute
    {
        return Attribute::make(
            get: fn (): int => $this->activeUsers->unique()->count()
        );
    }

    /**
     * @return Attribute<string, never>
     */
    public function tagsAsString(): Attribute
    {
        return Attribute::make(
            get: fn (): string => implode(', ', $this->tags ?? [])
        );
    }

    /**
     * @return Builder<Position>
     */
    public function buildSortQuery(): Builder
    {
        return static::query()->where('department_id', $this->department_id);
    }
}
