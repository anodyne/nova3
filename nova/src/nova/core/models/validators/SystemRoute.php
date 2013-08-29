<?php namespace nova\core\models\validators;

use BaseValidator;

class SystemRoute extends BaseValidator {

	public static $rules = array(
		'name'		=> 'required',
		'verb'		=> 'required',
		'uri'		=> 'required',
		'resource'	=> 'required',
	);

}