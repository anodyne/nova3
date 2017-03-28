<?php namespace Nova\Core\Menus\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class EditMenuRequest extends Request
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'name' => 'required',
			'key' => 'required',
		];
	}

	public function messages()
	{
		return [
			'name.required' => "Please enter a menu name",
			'key.required' => "Please enter a key for the menu",
		];
	}
}
