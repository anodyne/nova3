<?php namespace Nova\Core\Validators\Access;

use BaseValidator;

class Role extends BaseValidator {

	public static $rules = [
		'name' => 'required',
	];

}