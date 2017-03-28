<?php namespace Nova\Core\Menus\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class RemoveMenuRequest extends Request
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [];
	}

	public function messages()
	{
		return [];
	}
}
