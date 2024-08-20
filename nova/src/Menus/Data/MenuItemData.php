<?php

declare(strict_types=1);

namespace Nova\Menus\Data;

use Nova\Menus\Enums\LinkTarget;
use Nova\Menus\Enums\LinkType;
use Nova\Menus\Enums\MenuStatus;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;

class MenuItemData extends Data
{
    public function __construct(
        public string $label,
        public ?string $icon,
        public ?string $url,
        public ?int $page_id,
        public ?int $parent_id,

        #[Enum(LinkType::class)]
        public ?LinkType $link_type,

        #[Enum(LinkTarget::class)]
        public ?LinkTarget $target,

        #[Enum(MenuStatus::class)]
        public ?MenuStatus $status
    ) {}
}
