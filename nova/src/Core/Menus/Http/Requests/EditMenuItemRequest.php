<?php namespace Nova\Core\Menus\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class EditMenuItemRequest extends Request {

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
