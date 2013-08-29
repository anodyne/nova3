<?php namespace nova\core\models\validators\access;

use BaseValidator;

class Role extends BaseValidator {

	public static $rules = array(
		'name' => 'required',
	);

}