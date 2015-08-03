<?php namespace Nova\Core\Access\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class EditPermissionRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
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
			'name.required' => "Please enter a key for the permission",
		];
	}

}
