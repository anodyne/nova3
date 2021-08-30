<?php

declare(strict_types=1);

namespace Nova\Users\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Active as ActiveCharacter;
use Nova\Notes\Models\Note;
use Nova\Stories\Models\Post;
use Nova\Users\Events;
use Nova\Users\Models\Builders\UserBuilder;
use Nova\Users\Models\Collections\UsersCollection;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\States\ActiveToInactive;
use Nova\Users\Models\States\Inactive;
use Nova\Users\Models\States\Pending;
use Nova\Users\Models\States\UserStatus;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\ModelStates\HasStates;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use HasEagerLimit;
    use HasFactory;
    use HasStates;
    use InteractsWithMedia;
    use LaratrustUserTrait;
    use LogsActivity;
    use Notifiable;
    use SoftDeletes;

    public const MEDIA_DIRECTORY = 'users/{model_id}/{media_id}/';

    protected static $logFillable = true;

    protected $casts = [
        'force_password_reset' => 'boolean',
    ];

    protected $dispatchesEvents = [
        'created' => Events\UserCreated::class,
        'updated' => Events\UserUpdated::class,
        'deleted' => Events\UserDeleted::class,
    ];

    protected $fillable = [
        'name', 'email', 'password', 'force_password_reset', 'status',
        'pronouns', 'appearance',
    ];

    protected $hidden = [
        'password', 'remember_token', 'force_password_reset',
    ];

    public function characters()
    {
        return $this->belongsToMany(Character::class)
            ->withPivot('primary')
            ->withTimestamps();
    }

    public function activeCharacters()
    {
        return $this->characters()->where('status', ActiveCharacter::class);
    }

    public function primaryCharacter()
    {
        return $this->activeCharacters()->wherePivot('primary', true);
    }

    public function logins()
    {
        return $this->hasMany(Login::class);
    }

    public function latestLogin()
    {
        return $this->hasOne(Login::class)->ofMany();
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function posts()
    {
        return $this->morphMany(Post::class, 'authorable');
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
     * Can the user do any management in the app?
     *
     * @return bool
     */
    public function canManage(): bool
    {
        return $this->isAbleTo('department.*')
            || $this->isAbleTo('rank.*')
            || $this->isAbleTo('role.*')
            || $this->isAbleTo('theme.*')
            || $this->isAbleTo('user.*');
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     *
     * @return \Nova\Users\Models\UsersCollection
     */
    public function newCollection(array $models = []): UsersCollection
    {
        return new UsersCollection($models);
    }

    /**
     * Use the customized Eloquent builder when working with users.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return UserBuilder
     */
    public function newEloquentBuilder($query): UserBuilder
    {
        return new UserBuilder($query);
    }

    /**
     * Register the media collections for the model.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->useFallbackUrl("https://avatars.dicebear.com/api/bottts/{$this->email}.svg")
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
        $this->addState('status', UserStatus::class)
            ->allowTransitions([
                [Pending::class, Active::class],
                [Pending::class, Inactive::class],
                [Active::class, Inactive::class, ActiveToInactive::class],
                [Inactive::class, Active::class],
            ])
            ->default(Pending::class);
    }
}
