<?php

namespace Nova\Foundation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class ValidatesRequest extends FormRequest
{
    /**
     * Is the current user authorized to take the action on this request?
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * The validation rules for this request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * The validation messages for this request.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
