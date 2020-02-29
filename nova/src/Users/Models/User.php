<?php

namespace Nova\Users\Models;

use Nova\Users\Events;
use Nova\Users\UsersCollection;
use Spatie\ModelStates\HasStates;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\States\Pending;
use Nova\Users\Models\States\Archived;
use Nova\Users\Models\States\Inactive;
use Nova\Users\Models\States\UserState;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laracasts\Presenter\PresentableTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Nova\Users\Models\Builders\UserBuilder;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Nova\Users\Models\Presenters\UserPresenter;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use Notifiable;
    use SoftDeletes;
    use LogsActivity;
    use LaratrustUserTrait;
    use HasStates;
    use HasMediaTrait;
    use HasEagerLimit;
    use PresentableTrait;

    public const MEDIA_DIRECTORY = 'users/{model_id}/{media_id}/';

    protected static $logFillable = true;

    protected $casts = [
        'force_password_reset' => 'boolean',
    ];

    protected $dates = [
        'last_login',
    ];

    protected $dispatchesEvents = [
        'created' => Events\UserCreated::class,
        'updated' => Events\UserUpdated::class,
        'deleted' => Events\UserDeleted::class,
    ];

    protected $fillable = [
        'name', 'email', 'password', 'last_login', 'force_password_reset',
        'state', 'gender',
    ];

    protected $hidden = [
        'password', 'remember_token', 'force_password_reset',
    ];

    protected $presenter = UserPresenter::class;

    /**
     * Record a timestamp when a user logs in.
     *
     * @return \Nova\Users\Models\User
     */
    public function recordLoginTime()
    {
        return tap($this, function ($user) {
            $user->update(['last_login' => now()]);
        });
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
    public function getAvatarUrlAttribute()
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

    public function getPronounsAttribute()
    {
        switch ($this->gender) {
            case 'male':
                return 'He/Him';

            break;

            case 'female':
                return 'She/Her';

            break;

            case 'neutral':
            default:
                return 'They/Them';

            break;
        }
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     *
     * @return \Nova\Users\Models\UsersCollection
     */
    public function newCollection(array $models = [])
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
    public function newEloquentBuilder($query)
    {
        return new UserBuilder($query);
    }

    /**
     * Register the media collections for the model.
     *
     * @return void
     */
    public function registerMediaCollections()
    {
        $this->addMediaCollection('avatar')
            ->useFallbackUrl("https://api.adorable.io/avatars/285/{$this->email}")
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
        $this->addState('state', UserState::class)
            ->allowTransitions([
                [Pending::class, Active::class],
                [Pending::class, Inactive::class],

                [Active::class, Inactive::class],
                [Active::class, Archived::class],

                [Inactive::class, Archived::class],
                [Inactive::class, Active::class],
            ])
            ->default(Pending::class);
    }
}
