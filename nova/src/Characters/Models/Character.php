<?php

namespace Nova\Characters\Models;

use Nova\Characters\Events;
use Nova\Users\Models\User;
use Nova\Ranks\Models\RankItem;
use Spatie\ModelStates\HasStates;
use Nova\Departments\Models\Position;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\Activitylog\Traits\LogsActivity;
use Nova\Characters\Models\States\Types\Npc;
use Nova\Characters\Models\States\Types\Pnpc;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Nova\Characters\Models\States\Types\Primary;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Statuses\Pending;
use Nova\Characters\Models\States\Statuses\Inactive;
use Nova\Characters\Models\Builders\CharacterBuilder;
use Nova\Characters\Models\States\Types\CharacterType;
use Nova\Characters\Models\States\Statuses\CharacterStatus;
use Nova\Characters\Models\States\Statuses\ActiveToInactive;
use Nova\Stories\Models\Post;

class Character extends Model implements HasMedia
{
    use LogsActivity;
    use HasStates;
    use HasMediaTrait;
    use HasEagerLimit;

    public const MEDIA_DIRECTORY = 'characters/{model_id}/{media_id}/';

    protected static $logFillable = true;

    protected $dispatchesEvents = [
        'created' => Events\CharacterCreated::class,
        'updated' => Events\CharacterUpdated::class,
        'deleted' => Events\CharacterDeleted::class,
    ];

    protected $fillable = [
        'name', 'status',
    ];

    public function positions()
    {
        return $this->belongsToMany(Position::class)->withPivot('primary');
    }

    public function posts()
    {
        return $this->morphMany(Post::class, 'authorable');
    }

    public function rank()
    {
        return $this->hasOne(RankItem::class, 'id', 'rank_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getHasUserAttribute(): bool
    {
        return $this->users()->count() > 0;
    }

    public function getIsNpcAttribute(): bool
    {
        return $this->users()->count() === 0;
    }

    public function getIsPnpcAttribute(): bool
    {
        return false;
    }

    /**
     * Set the description for logging.
     *
     * @param  string  $eventName
     *
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return ":subject.name was {$eventName}";
    }

    /**
     * Get the URL of the user's avatar.
     *
     * @return string
     */
    public function getAvatarUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('avatar');
    }

    /**
     * Does the user have an avatar?
     *
     * @return bool
     */
    public function getHasAvatarAttribute(): bool
    {
        return $this->getFirstMedia('avatar') !== null;
    }

    /**
     * Use the customized Eloquent builder when working with users.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return CharacterBuilder
     */
    public function newEloquentBuilder($query): CharacterBuilder
    {
        return new CharacterBuilder($query);
    }

    /**
     * Register the media collections for the model.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->useFallbackUrl("https://api.adorable.io/avatars/285/{str_replace(' ', '', {$this->name})}")
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif'])
            ->singleFile();
    }

    /**
     * Register the states and transitions for the model.
     *
     * @return void
     */
    protected function registerStates(): void
    {
        $this->addState('status', CharacterStatus::class)
            ->allowTransitions([
                [Pending::class, Active::class],
                [Pending::class, Inactive::class],
                [Active::class, Inactive::class, ActiveToInactive::class],
                [Inactive::class, Active::class],
            ])
            ->default(Pending::class);

        $this->addState('type', CharacterType::class)
            ->allowTransitions([
                [Primary::class, Npc::class],
                [Primary::class, Pnpc::class],

                [Npc::class, Pnpc::class],
                [Npc::class, Primary::class],

                [Pnpc::class, Npc::class],
                [Pnpc::class, Primary::class],
            ])
            ->default(NPC::class);
    }
}