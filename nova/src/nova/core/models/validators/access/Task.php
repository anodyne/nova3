<?php namespace Nova\Core\Models\Validators\Access;

use BaseValidator;

class Task extends BaseValidator {

	public static $rules = array(
		'name'		=> 'required',
		'component'	=> 'required',
		'action'	=> 'required',
		'level'		=> 'required|integer',
	);

}