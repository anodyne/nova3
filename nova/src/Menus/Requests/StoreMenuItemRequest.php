<?php

declare(strict_types=1);

namespace Nova\Menus\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Nova\Menus\Data\MenuItemData;
use Nova\Menus\Enums\LinkTarget;
use Nova\Menus\Enums\LinkType;

class StoreMenuItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'icon' => ['nullable'],
            'label' => ['required'],
            'link_type' => ['required', Rule::enum(LinkType::class)],
            'page_id' => ['required_if:link_type,page'],
            'parent_id' => ['nullable'],
            'status' => ['required'],
            'target' => ['required', Rule::enum(LinkTarget::class)],
            'url' => ['required_if:link_type,url'],
        ];
    }

    public function getMenuItemData(): MenuItemData
    {
        return MenuItemData::from($this);
    }
}
