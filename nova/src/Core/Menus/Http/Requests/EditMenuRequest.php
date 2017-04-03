<?php namespace Nova\Core\Menus\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class EditMenuRequest extends Request
{
	protected $rules = [
		'name' => 'required',
		'key' => 'required',
	];

	protected $messages = [
		'name.required' => "Please enter a menu name",
		'key.required' => "Please enter a key for the menu",
	];
}
