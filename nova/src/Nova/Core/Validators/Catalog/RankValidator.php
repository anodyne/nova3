<?php namespace Nova\Core\Validators\Catalog;

use BaseValidator;

class RankValidator extends BaseValidator {

	public static $rules = [
		'name'		=> 'required',
		'location'	=> 'required',
		'preview'	=> 'required',
		'blank'		=> 'required',
		'extension'	=> 'required|in:.png,.jpg,.gif,.jpeg,.bmp',
		'status'	=> 'required|numeric',
	];

}