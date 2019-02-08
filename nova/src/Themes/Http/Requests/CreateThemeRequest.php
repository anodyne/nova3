<?php

namespace Nova\Themes\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateThemeRequest extends FormRequest
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
            'layout_auth' => ['required'],
            'layout_admin' => ['required'],
            'layout_public' => ['required'],
            'variants' => ['nullable'],
            'icon_set' => ['nullable'],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'location.unique' => 'A theme already exists at that location.'
        ];
    }
}