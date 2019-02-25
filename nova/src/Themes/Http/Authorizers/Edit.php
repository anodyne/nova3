<?php

namespace Nova\Themes\Http\Authorizers;

use Nova\Themes\Theme;
use Nova\Foundation\Http\Requests\BaseFormRequest;

class Edit extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $theme = Theme::find($this->route('theme'));

        return $this->user()->can('update', $theme);
    }
}