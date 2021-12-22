<?php

declare(strict_types=1);

namespace Nova\Characters\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nova\Characters\Events;
use Nova\Characters\Models\Builders\CharacterBuilder;
use Nova\Characters\Models\States\Statuses\CharacterStatus;
use Nova\Characters\Models\States\Types\CharacterType;
use Nova\Departments\Models\Position;
use Nova\Ranks\Models\RankItem;
use Nova\Stories\Models\Post;
use Nova\Users\Models\States\Active as ActiveUser;
use Nova\Users\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
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

    public const MEDIA_DIRECTORY = 'characters/{model_id}/{media_id}/';

    protected static $logFillable = true;

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
        'name', 'status', 'rank_id',
    ];

    public function activeUsers()
    {
        return $this->users()->whereState('status', ActiveUser::class);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class)->withPivot('primary');
    }

    public function posts()
    {
        return $this->morphMany(Post::class, 'authorable');
    }

    public function primaryPosition()
    {
        return $this->positions()->wherePivot('primary', true);
    }

    public function primaryUsers()
    {
        return $this->activeUsers()->wherePivot('primary', true);
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

    public function getDescriptionForEvent(string $eventName): string
    {
        return ":subject.name was {$eventName}";
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('avatar');
    }

    public function getHasAvatarAttribute(): bool
    {
        return $this->getFirstMedia('avatar') !== null;
    }

    public function newEloquentBuilder($query): CharacterBuilder
    {
        return new CharacterBuilder($query);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->useFallbackUrl("https://avatars.dicebear.com/api/bottts/{str_replace(' ', '', {$this->name})}.svg")
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif'])
            ->singleFile();
    }
}
