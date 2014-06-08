<?php namespace Nova\Core\Validators\Access;

use BaseValidator;

class TaskValidator extends BaseValidator {

	public static $rules = [
		'name'		=> 'required',
		'component'	=> 'required',
		'action'	=> 'required',
		'level'		=> 'required|integer',
	];

}