<?php namespace Nova\Core\Validators;

class UserValidator extends \BaseValidator {

	public static $rules = [
		'name'				=> 'required',
		'email'				=> 'required|email',
		'password'			=> 'required',
		'password_confirm'	=> 'required|same:password',
	];

}