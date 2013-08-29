<?php namespace nova\core\models\validators\catalog;

use BaseValidator;

class Skin extends BaseValidator {

	public static $rules = [
		'name'		=> 'required',
		'location'	=> 'required',
		'nav'		=> 'required|in:dropdown,classic',
		'status'	=> 'required|numeric',
	];

}