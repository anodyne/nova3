<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Pages\Models\Page;

class DeletePage extends Action
{
    public function handle(Page $page): Page
    {
        $page = tap($page)->delete();

        BustPagesCache::run();
        RecachePages::run();

        return $page;
    }
}
