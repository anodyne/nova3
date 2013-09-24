<?php namespace Nova\Core\Validators\Access;

use BaseValidator;

class Task extends BaseValidator {

	public static $rules = [
		'name'		=> 'required',
		'component'	=> 'required',
		'action'	=> 'required',
		'level'		=> 'required|integer',
	];

}