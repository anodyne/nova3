<?php namespace Nova\Core\Models\Validators\Catalog;

use BaseValidator;

class Rank extends BaseValidator {

	public static $rules = [
		'name'		=> 'required',
		'location'	=> 'required',
		'preview'	=> 'required',
		'blank'		=> 'required',
		'extension'	=> 'required|in:.png,.jpg,.gif,.jpeg,.bmp',
		'status'	=> 'required|numeric',
	];

}