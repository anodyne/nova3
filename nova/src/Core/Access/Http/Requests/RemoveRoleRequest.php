<?php namespace Nova\Core\Access\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class RemoveRoleRequest extends Request
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
