<?php namespace Nova\Foundation;

use Mail;
use Nova\Auth\Mail\SendPasswordReset;
use Illuminate\Notifications\Notifiable;
use Nova\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function sendPasswordResetNotification($token)
	{
		Mail::to($this->email)->send(new SendPasswordReset($token));
	}
}
