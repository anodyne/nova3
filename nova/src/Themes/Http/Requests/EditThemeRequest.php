<?php

namespace Nova\Themes\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditThemeRequest extends FormRequest
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
            'credits' => ['nullable'],
            'layout_auth' => ['required'],
            'layout_admin' => ['required'],
            'layout_public' => ['required'],
            'icon_set' => ['nullable'],
        ];
    }
}
