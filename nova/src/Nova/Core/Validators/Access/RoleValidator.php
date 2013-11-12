<?php namespace Nova\Core\Validators\Access;

use BaseValidator;

class RoleValidator extends BaseValidator {

	public static $rules = [
		'name' => 'required',
	];

}