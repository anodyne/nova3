<?php namespace nova\core\models\validators\form;

use BaseValidator;

class Value extends BaseValidator {

	public static $rules = [
		'field_id'	=> 'required|numeric',
		'value'		=> 'required',
		'content'	=> 'required',
		'order'		=> 'numeric',
	];

}