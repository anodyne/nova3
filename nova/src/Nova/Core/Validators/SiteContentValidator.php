<?php namespace Nova\Core\Validators;

class SiteContentValidator extends \BaseValidator {

	public static $rules = [
		'key'		=> 'required',
		'label'		=> 'required',
		'type'		=> 'required',
		'uri'		=> 'required_if:type,header|required_if:type,title|required_if:type,message',
	];

}