<?php

declare(strict_types=1);

namespace Nova\Foundation\Responses;

use Nova\Menus\Models\Menu;

class ResponseMeta
{
    public function __construct(
        public ?string $layout,
        public ?string $structure,
        public ?string $subnav,
        public ?string $subnavSection,
        public ?string $template,
        public ?Menu $menu,
        public ?string $pageHeading = null,
        public ?string $pageSubheading = null,
        public ?string $pageIntro = null
    ) {}
}
