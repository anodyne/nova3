<?php

namespace Nova\Themes\Http\Requests;

use Nova\Foundation\Http\Requests\BaseFormRequest;

class Store extends BaseFormRequest
{
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
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'location.unique' => 'A theme already exists at that location.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'location' => ['required', 'unique:themes,location'],
            'credits' => ['nullable'],
            'variants' => ['nullable'],
        ];
    }
}
