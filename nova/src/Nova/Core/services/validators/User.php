<?php namespace Nova\Core\Services\Validators;

use BaseValidator;

class User extends BaseValidator {

	protected static $rules = array(
		'email'				=> 'required|email',
		'password'			=> 'required',
		'password_confirm'	=> 'required|same:password',
	);

}