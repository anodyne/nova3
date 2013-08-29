<?php namespace nova\core\models\validators\form;

use BaseValidator;

class Tab extends BaseValidator {

	public static $rules = array(
		'form_id'		=> 'required|numeric',
		'name'			=> 'required',
		'status'		=> 'required|numeric',
	);

}