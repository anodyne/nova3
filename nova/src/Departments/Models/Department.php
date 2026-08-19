<?php

declare(strict_types=1);

namespace Nova\Departments\Models;

use Carbon\CarbonImmutable;
use Database\Factories\DepartmentFactory;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Active as CharacterActive;
use Nova\Departments\Events\DepartmentCreated;
use Nova\Departments\Events\DepartmentDeleted;
use Nova\Departments\Events\DepartmentUpdated;
use Nova\Departments\Models\Builders\DepartmentBuilder;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Models\Model;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Users\Models\States\Status\Active as UserActive;
use Nova\Users\Models\User;
use Spatie\Activitylog\Models\Activity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $name
 * @property string|null $description
 * @property int|null $order_column
 * @property BasicStatus $status
 * @property array<array-key, mixed>|null $tags
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, Position> $positions
 * @property-read int|null $positions_count
 * @property-read mixed $tags_as_string
 * @property-read Collection<int, Character> $activeCharacters
 * @property-read int|null $active_characters_count
 * @property-read Collection<int, User> $activeUsers
 * @property-read int|null $active_users_count
 * @property-read Collection<int, Character> $characters
 * @property-read int|null $characters_count
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static DepartmentBuilder<static>|Department active()
 * @method static DepartmentFactory factory($count = null, $state = [])
 * @method static DepartmentBuilder<static>|Department hasTags(array $tags)
 * @method static DepartmentBuilder<static>|Department inactive()
 * @method static DepartmentBuilder<static>|Department newModelQuery()
 * @method static DepartmentBuilder<static>|Department newQuery()
 * @method static DepartmentBuilder<static>|Department ordered(string $direction = 'asc')
 * @method static DepartmentBuilder<static>|Department query()
 * @method static DepartmentBuilder<static>|Department searchFor($search)
 * @method static DepartmentBuilder<static>|Department uniqueTags()
 * @method static DepartmentBuilder<static>|Department whereCreatedAt($value)
 * @method static DepartmentBuilder<static>|Department whereDescription($value)
 * @method static DepartmentBuilder<static>|Department whereId($value)
 * @method static DepartmentBuilder<static>|Department whereName($value)
 * @method static DepartmentBuilder<static>|Department whereOrderColumn($value)
 * @method static DepartmentBuilder<static>|Department wherePrefixedId($value)
 * @method static DepartmentBuilder<static>|Department whereStatus($value)
 * @method static DepartmentBuilder<static>|Department whereTags($value)
 * @method static DepartmentBuilder<static>|Department whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(DepartmentBuilder::class)]
class Department extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use HasPrefixedId;
    use HasRelationships;
    use InteractsWithMedia;
    use LogsActivity;
    use SortableTrait;

    protected $casts = [
        'order_column' => 'integer',
        'status' => BasicStatus::class,
        'tags' => 'array',
    ];

    protected $dispatchesEvents = [
        'created' => DepartmentCreated::class,
        'deleted' => DepartmentDeleted::class,
        'updated' => DepartmentUpdated::class,
    ];

    protected $fillable = ['name', 'description', 'order_column', 'status', 'tags'];

    protected $table = 'departments';

    public function activeCharacters(): HasManyDeep
    {
        return $this->characters()
            ->whereState(Character::column('status'), CharacterActive::class);
    }

    public function activeUsers(): HasManyDeep
    {
        return $this->users()
            ->where(User::column('status'), UserActive::$name)
            ->where(Character::column('status'), CharacterActive::$name);
    }

    public function characters(): HasManyDeep
    {
        return $this->hasManyDeep(
            Character::class,
            [Position::class, 'character_position']
        );
    }

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class)->ordered();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('header')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile()
            ->useDisk('media-departments');
    }

    public function tagsAsString(): Attribute
    {
        return Attribute::make(
            get: fn (): string => implode(', ', $this->tags ?? [])
        );
    }

    public function users(): HasManyDeep
    {
        return $this->hasManyDeep(
            User::class,
            [Position::class, 'character_position', Character::class, 'character_user']
        );
    }

    public static function getMediaPath(): string
    {
        return '{model_id}/{media_id}/';
    }
}
