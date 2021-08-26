<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Nova\Pages\Page;

class RouteMacros
{
    public function findPageFromRoute()
    {
        return function () {
            return Page::key($this->getName())->first();
        };
    }
}
