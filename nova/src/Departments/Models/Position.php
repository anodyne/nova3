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

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property int $department_id
 * @property string $name
 * @property string|null $description
 * @property int $available
 * @property BasicStatus $status
 * @property array<array-key, mixed>|null $tags
 * @property int|null $order_column
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read CharacterPosition|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Character> $activeCharacters
 * @property-read int|null $active_characters_count
 * @property-read int|null $active_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Character> $characters
 * @property-read int|null $characters_count
 * @property-read \Nova\Departments\Models\Department $department
 * @property-read mixed $tags_as_string
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $activeUsers
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $users
 * @property-read int|null $users_count
 * @method static PositionBuilder<static>|Position active()
 * @method static PositionBuilder<static>|Position available()
 * @method static PositionBuilder<static>|Position department($id)
 * @method static \Database\Factories\PositionFactory factory($count = null, $state = [])
 * @method static PositionBuilder<static>|Position hasTags(array $tags)
 * @method static PositionBuilder<static>|Position inactive()
 * @method static PositionBuilder<static>|Position newModelQuery()
 * @method static PositionBuilder<static>|Position newQuery()
 * @method static PositionBuilder<static>|Position ordered(string $direction = 'asc')
 * @method static PositionBuilder<static>|Position query()
 * @method static PositionBuilder<static>|Position searchFor($search)
 * @method static PositionBuilder<static>|Position uniqueTags()
 * @method static PositionBuilder<static>|Position whereAvailable($value)
 * @method static PositionBuilder<static>|Position whereCreatedAt($value)
 * @method static PositionBuilder<static>|Position whereDepartmentId($value)
 * @method static PositionBuilder<static>|Position whereDescription($value)
 * @method static PositionBuilder<static>|Position whereId($value)
 * @method static PositionBuilder<static>|Position whereName($value)
 * @method static PositionBuilder<static>|Position whereOrderColumn($value)
 * @method static PositionBuilder<static>|Position wherePrefixedId($value)
 * @method static PositionBuilder<static>|Position whereStatus($value)
 * @method static PositionBuilder<static>|Position whereTags($value)
 * @method static PositionBuilder<static>|Position whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
