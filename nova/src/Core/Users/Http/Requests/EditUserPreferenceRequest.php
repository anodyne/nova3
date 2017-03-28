<?php namespace Nova\Core\Users\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class EditUserPreferenceRequest extends Request
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
