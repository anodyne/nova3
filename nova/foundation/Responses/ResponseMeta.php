<?php

declare(strict_types=1);

namespace Nova\Foundation\Responses;

use Nova\Menus\Models\Menu;

class ResponseMeta
{
    public ?string $layout;

    public ?string $structure;

    public ?string $subnav;

    public ?string $subnavSection;

    public ?string $template;

    public ?Menu $menu;

    public function __construct(array $data)
    {
        $this->layout = data_get($data, 'layout');
        $this->structure = data_get($data, 'structure');
        $this->subnav = data_get($data, 'subnav');
        $this->subnavSection = data_get($data, 'subnavSection');
        $this->template = data_get($data, 'template');
        $this->menu = data_get($data, 'menu');
    }
}
