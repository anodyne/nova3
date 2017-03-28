<?php namespace Nova\Core\Pages\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class RemovePageRequest extends Request
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
