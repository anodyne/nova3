<?php

namespace Nova\Authorize\Http\Requests;

use Nova\Authorize\Permission;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
{
	public function authorize()
	{
		return $this->user()->can('update', $this->route('permission'));
	}

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
			'name.required' => _m('validation-name-required'),
			'key.required' => _m('validation-key-required'),
		];
	}
}
