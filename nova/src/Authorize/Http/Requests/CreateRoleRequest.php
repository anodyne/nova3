<?php

namespace Nova\Authorize\Http\Requests;

use Nova\Authorize\Role;
use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
{
    public function authorize()
    {
		return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
        ];
	}

	public function messages()
	{
		return [
			'name.required' => _m('validation-name-required'),
		];
	}
}
