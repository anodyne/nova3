<?php namespace Nova\Core\Services\Validators\Access;

use BaseValidator;

class Task extends BaseValidator {

	protected static $rules = array(
		'name'			=> 'required',
		'desc'			=> 'required',
		'component'		=> 'required',
		'action'		=> 'required',
		'level'			=> 'integer',
	);

}