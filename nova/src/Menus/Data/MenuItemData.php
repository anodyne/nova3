<?php

declare(strict_types=1);

namespace Nova\Menus\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Menus\Enums\LinkTarget;
use Nova\Menus\Enums\LinkType;

readonly class MenuItemData extends Bag
{
    public function __construct(
        public string $label,
        public ?string $icon,
        public ?string $url,
        public ?int $page_id,
        public ?int $parent_id,
        public LinkType $link_type,
        public LinkTarget $target,
        public BasicStatus $status
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'label' => $request->input('label'),
            'icon' => $request->input('icon'),
            'url' => $request->input('url'),
            'page_id' => $request->input('page_id'),
            'parent_id' => $request->input('parent_id'),
            'link_type' => LinkType::tryFrom($request->input('link_type')) ?? LinkType::Url,
            'target' => LinkTarget::tryFrom($request->input('target')) ?? LinkTarget::Blank,
            'status' => BasicStatus::tryFrom($request->input('status')) ?? BasicStatus::Active,
        ];
    }
}
