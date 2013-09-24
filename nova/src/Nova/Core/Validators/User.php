<?php namespace Nova\Core\Validators;

use BaseValidator;

class User extends BaseValidator {

	public static $rules = [
		'name'				=> 'required',
		'email'				=> 'required|email',
		'password'			=> 'required',
		'password_confirm'	=> 'required|same:password',
	];

}