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
			'name'	=> 'required',
			'key'	=> 'required',
		];
	}

	public function messages()
	{
		return [
			'name.required' => "Please enter a name",
			'key.required' => "Please enter a key",
		];
	}

}
