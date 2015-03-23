<?php namespace Nova\Core\Pages\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class RemovePageContentRequest extends Request {

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
			//
		];
	}

	public function messages()
	{
		return [
			//
		];
	}

}
