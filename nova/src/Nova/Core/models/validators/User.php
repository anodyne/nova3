<?php namespace Nova\Core\Models\Validators;

use BaseValidator;

class User extends BaseValidator {

	public static $rules = array(
		'email'				=> 'required|email',
		'password'			=> 'required',
		'password_confirm'	=> 'required|same:password',
	);

}