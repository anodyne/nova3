<?php namespace Nova\Core\Services\Validators\Access;

use BaseValidator;

class Role extends BaseValidator {

	public static $rules = array(
		'name'			=> 'required',
		'desc'			=> 'required',
	);

}