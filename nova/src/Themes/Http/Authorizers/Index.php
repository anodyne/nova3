<?php

namespace Nova\Themes\Http\Authorizers;

use Nova\Themes\Theme;
use Nova\Foundation\Http\Requests\BaseFormRequest;

class Index extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        return $this->user()->can('manage', Theme::class);
    }

    /**
     *
     */
    public function userPermissions()
    {
        return [
            'create' => true,
            'delete' => true,
            'update' => true,
            // 'create' => $this->user()->can('create', Theme::class),
            // 'delete' => $this->user()->can('delete', Theme::class),
            // 'update' => $this->user()->can('update', Theme::class),
        ];
    }
}