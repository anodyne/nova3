<?php

declare(strict_types=1);

namespace Nova\Departments\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Active as CharacterActive;
use Nova\Departments\Events;
use Nova\Departments\Models\Builders\DepartmentBuilder;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Users\Models\States\Status\Active as UserActive;
use Nova\Users\Models\User;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Department extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use HasPrefixedId;
    use HasRelationships;
    use InteractsWithMedia;
    use LogsActivity;
    use SortableTrait;

    protected $table = 'departments';

    protected $fillable = ['name', 'description', 'order_column', 'status', 'tags'];

    protected $casts = [
        'order_column' => 'integer',
        'status' => BasicStatus::class,
        'tags' => 'array',
    ];

    protected $dispatchesEvents = [
        'created' => Events\DepartmentCreated::class,
        'deleted' => Events\DepartmentDeleted::class,
        'updated' => Events\DepartmentUpdated::class,
    ];

    public function activeCharacters(): HasManyDeep
    {
        return $this->characters()->whereState('characters.status', CharacterActive::class);
    }

    public function activeUsers(): HasManyDeep
    {
        return $this->users()->whereState('users.status', UserActive::class);
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

    public function users(): HasManyDeep
    {
        return $this->hasManyDeep(
            User::class,
            [Position::class, 'character_position', Character::class, 'character_user']
        )->distinct();
    }

    public function tagsAsString(): Attribute
    {
        return Attribute::make(
            get: fn () => implode(', ', $this->tags)
        );
    }

    public function newEloquentBuilder($query): DepartmentBuilder
    {
        return new DepartmentBuilder($query);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('header')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile()
            ->useDisk('media-departments');
    }

    public static function getMediaPath(): string
    {
        return '{model_id}/{media_id}/';
    }
}
