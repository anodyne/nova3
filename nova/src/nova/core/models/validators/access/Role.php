<?php namespace Nova\Core\Models\Validators\Access;

use BaseValidator;

class Role extends BaseValidator {

	public static $rules = array(
		'name' => 'required',
	);

}