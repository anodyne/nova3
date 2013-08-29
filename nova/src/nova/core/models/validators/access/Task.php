<?php namespace nova\core\models\validators\access;

use BaseValidator;

class Task extends BaseValidator {

	public static $rules = array(
		'name'		=> 'required',
		'component'	=> 'required',
		'action'	=> 'required',
		'level'		=> 'required|integer',
	);

}