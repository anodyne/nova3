<?php namespace nova\core\models\validators;

use BaseValidator;

class User extends BaseValidator {

	public static $rules = array(
		'name'				=> 'required',
		'email'				=> 'required|email',
		'password'			=> 'required',
		'password_confirm'	=> 'required|same:password',
	);

}