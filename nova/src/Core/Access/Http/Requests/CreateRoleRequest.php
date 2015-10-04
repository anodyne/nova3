<?php namespace Nova\Core\Access\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class CreateRoleRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'display_name'	=> 'required',
			'name'			=> 'required',
		];
	}

	public function messages()
	{
		return [
			'display_name.required' => "Please enter a display name",
			'name.required' => "Please enter a key for the role",
		];
	}

}
