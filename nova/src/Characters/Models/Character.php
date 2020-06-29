<?php

namespace Nova\Characters\Models;

use Nova\Characters\Events;
use Nova\Users\Models\User;
use Spatie\ModelStates\HasStates;
use Nova\Users\Models\UserCharacter;
use Illuminate\Database\Eloquent\Model;
use Nova\Characters\Models\States\Active;
use Nova\Characters\Models\States\Pending;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Nova\Characters\Models\States\Inactive;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Nova\Characters\Models\States\CharacterStatus;
use Nova\Characters\Models\Builders\CharacterBuilder;
use Nova\Characters\Models\States\CharacterType;
use Nova\Characters\Models\States\NPC;
use Nova\Characters\Models\States\PlayingCharacter;
use Nova\Characters\Models\States\PNPC;
use Nova\Departments\Models\Position;
use Nova\Ranks\Models\RankItem;

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
        return $this->belongsToMany(Position::class);
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

                [Active::class, Inactive::class],

                [Inactive::class, Active::class],
            ])
            ->default(Pending::class);

        $this->addState('type', CharacterType::class)
            ->allowTransitions([
                [PlayingCharacter::class, NPC::class],
                [PlayingCharacter::class, PNPC::class],

                [NPC::class, PNPC::class],
                [NPC::class, PlayingCharacter::class],

                [PNPC::class, NPC::class],
                [PNPC::class, PlayingCharacter::class],
            ])
            ->default(NPC::class);
    }
}
