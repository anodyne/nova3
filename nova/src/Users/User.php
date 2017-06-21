<?php namespace Nova\Users;

use Mail;
use Nova\Auth\Mail\SendPasswordReset;
use Illuminate\Notifications\Notifiable;
use Nova\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	protected $table = 'users';
	protected $fillable = ['name', 'email', 'password'];
	protected $hidden = ['password', 'remember_token'];

	//--------------------------------------------------------------------------
	// Model Methods
	//--------------------------------------------------------------------------

	public function sendPasswordResetNotification($token)
	{
		Mail::to($this->email)->send(new SendPasswordReset($token));
	}
}
