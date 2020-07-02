<?php

namespace Nova\Foundation\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class AuthorizesRequest extends FormRequest
{
    /**
     * Is the current user authorized to take the action on this request?
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
