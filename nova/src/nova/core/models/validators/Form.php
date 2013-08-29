<?php namespace nova\core\models\validators;

use BaseValidator;

class Form extends BaseValidator {

	public static $rules = array(
		'key'			=> 'required',
		'name'			=> 'required',
		'orientation'	=> 'required|in:vertical,horizontal',
		'status'		=> 'required|numeric',
	);

}