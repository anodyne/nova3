<?php

namespace Nova\Users\Models;

use Nova\Users\Events;
use Nova\Users\UsersCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes, HasRolesAndAbilities;

    protected $fillable = [
        'name', 'email', 'password', 'last_login', 'force_password_reset',
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
        'created' => Events\Created::class,
        'updated' => Events\Updated::class,
        'deleted' => Events\Deleted::class,
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
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Nova\Users\Models\UsersCollection
     */
    public function newCollection(array $models = [])
    {
        return new UsersCollection($models);
    }
}
