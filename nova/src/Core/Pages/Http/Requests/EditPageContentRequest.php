<?php namespace Nova\Core\Pages\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class EditPageContentRequest extends Request
{
	protected $rules = [
		'key' => 'required',
	];

	protected $messages = [
		'key.required' => "Please enter a key for the page content",
	];
}
