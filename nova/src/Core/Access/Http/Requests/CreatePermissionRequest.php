<?php namespace Nova\Core\Access\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class CreatePermissionRequest extends Request
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'name'		=> 'required',
			'component'	=> 'required',
			'action'	=> 'required',
		];
	}

	public function messages()
	{
		return [
			'name.required' => "Please enter a name",
			'component.required' => "Please enter a component",
			'action.required' => "Please enter an action",
		];
	}
}
