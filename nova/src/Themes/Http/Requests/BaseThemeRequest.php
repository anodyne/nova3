<?php

namespace Nova\Themes\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseThemeRequest extends FormRequest
{
    protected $rules = [];

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
        $baseRules = [
            'name' => ['required'],
            'location' => ['required'],
            'credits' => ['nullable'],
            'variants' => ['nullable'],
        ];

        return array_merge_recursive($baseRules, $this->rules);
    }
}
