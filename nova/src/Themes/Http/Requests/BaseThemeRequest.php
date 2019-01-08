<?php

namespace Nova\Themes\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseThemeRequest extends FormRequest
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
        return array_merge_recursive([
            'name' => ['required'],
            'location' => ['required'],
            'credits' => ['nullable'],
            'layout_auth' => ['required'],
            'layout_auth_settings' => ['nullable'],
            'layout_admin' => ['required'],
            'layout_admin_settings' => ['nullable'],
            'layout_public' => ['required'],
            'layout_public_settings' => ['nullable'],
            'variants' => ['nullable'],
            'icon_set' => ['nullable'],
        ], $this->rulesOverride());
    }

    /**
     * Get the validation rules that are different from the base rules for this
     * type of request.
     *
     * @return array
     */
    public function rulesOverride()
    {
        return [];
    }
}
