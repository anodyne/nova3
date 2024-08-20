<?php

declare(strict_types=1);

namespace Nova\Menus\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Menus\Data\MenuItemData;

class StoreMenuItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'label' => ['required'],
            'icon' => ['nullable'],
            'link_type' => ['required'],
            'url' => ['required_if:link_type,url'],
            'page_id' => ['required_if:link_type,page'],
            'status' => ['required'],
            'parent_id' => ['nullable'],
            'target' => ['required', 'in:_self,_blank'],
        ];
    }

    public function getMenuItemData(): MenuItemData
    {
        return MenuItemData::from($this);
    }
}
