<?php

declare(strict_types=1);

namespace Nova\Characters\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Events;
use Nova\Characters\Models\Builders\CharacterBuilder;
use Nova\Characters\Models\States\Status\CharacterStatus;
use Nova\Departments\Models\Position;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Ranks\Models\RankItem;
use Nova\Stories\Models\Post;
use Nova\Users\Models\States\Active as ActiveUser;
use Nova\Users\Models\User;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\ModelStates\HasStates;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Character extends Model implements HasMedia
{
    use HasEagerLimit;
    use HasFactory;
    use HasStates;
    use InteractsWithMedia;
    use LogsActivity;
    use SoftDeletes;

    protected $casts = [
        'status' => CharacterStatus::class,
        'type' => CharacterType::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\CharacterCreated::class,
        'deleted' => Events\CharacterDeleted::class,
        'updated' => Events\CharacterUpdated::class,
    ];

    protected $fillable = [
        'name', 'status', 'rank_id', 'type',
    ];

    public function activeUsers()
    {
        return $this->users()->whereState('status', ActiveUser::class);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class)->withPivot('primary');
    }

    public function posts(): MorphToMany
    {
        return $this->morphToMany(Post::class, 'authorable', 'post_author');
    }

    public function primaryPosition()
    {
        return $this->positions()->wherePivot('primary', true);
    }

    public function activePrimaryUsers()
    {
        return $this->activeUsers()->wherePivot('primary', true);
    }

    public function primaryUsers()
    {
        return $this->users()->wherePivot('primary', true);
    }

    public function rank()
    {
        return $this->hasOne(RankItem::class, 'id', 'rank_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('primary')
            ->withTimestamps();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(
                fn (string $eventName) => ":subject.name was {$eventName}"
            );
    }

    public function avatarUrl(): Attribute
    {
        return new Attribute(
            get: fn ($value): string => $this->getFirstMediaUrl('avatar')
        );
    }

    public function displayName(): Attribute
    {
        return new Attribute(
            get: fn ($value): string => trim($this?->rank?->name?->name.' '.$this->name)
        );
    }

    public function hasAvatar(): Attribute
    {
        return new Attribute(
            get: fn ($value): bool => $this->getFirstMedia('avatar') !== null
        );
    }

    public function rankId(): Attribute
    {
        return new Attribute(
            set: fn ($value): ?int => $value === 0 ? null : $value
        );
    }

    public function newEloquentBuilder($query): CharacterBuilder
    {
        return new CharacterBuilder($query);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->useFallbackUrl("https://avatars.dicebear.com/api/bottts/{str_replace(' ', '', {$this->name})}.svg")
            ->useDisk('media')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif'])
            ->singleFile();
    }

    public static function getMediaPath(): string
    {
        return 'characters/{model_id}/{media_id}/';
    }
}
