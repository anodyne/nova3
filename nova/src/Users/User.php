<?php

namespace Nova\Users;

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

    /**
     * Record a timestamp when a user logs in.
     *
     * @return \Nova\Users\User
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
     * @return \Nova\Users\User
     */
    public function forcePasswordReset()
    {
        return tap($this, function ($user) {
            $user->update(['force_password_reset' => true]);
        });
    }
}
