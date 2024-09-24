<?php

declare(strict_types=1);

namespace Nova\Departments\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Active as CharacterActive;
use Nova\Departments\Enums\DepartmentStatus;
use Nova\Departments\Events;
use Nova\Departments\Models\Builders\DepartmentBuilder;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Users\Models\States\Status\Active as UserActive;
use Nova\Users\Models\User;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
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
        'status' => DepartmentStatus::class,
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

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()->logFillable();

        if (app('impersonate')->isImpersonating()) {
            return $logOptions->useLogName('impersonation')
                ->setDescriptionForEvent(
                    fn (string $eventName): string => ":subject.name department was {$eventName} during impersonation by ".app('impersonate')->getImpersonator()->name
                );
        }

        return $logOptions
            ->setDescriptionForEvent(
                fn (string $eventName): string => ":subject.name department was {$eventName}"
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
            ->useDisk('media');
    }

    public static function getMediaPath(): string
    {
        return 'departments/{model_id}/{media_id}/';
    }
}
