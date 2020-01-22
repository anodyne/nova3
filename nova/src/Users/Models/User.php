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
use Nova\Users\Models\Builders\UserBuilder;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    use LogsActivity;
    use LaratrustUserTrait;
    use HasStates;

    protected static $logFillable = true;

    protected $fillable = [
        'name', 'email', 'password', 'last_login', 'force_password_reset',
        'state',
    ];

    protected $hidden = [
        'password', 'remember_token', 'force_password_reset',
    ];

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
     * Force the user to reset their password.
     *
     * @return \Nova\Users\Models\User
     */
    public function forcePasswordReset()
    {
        return tap($this, function ($user) {
            $user->update(['force_password_reset' => true]);
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
