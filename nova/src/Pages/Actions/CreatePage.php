<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Pages\Data\PageData;
use Nova\Pages\Models\Page;

class CreatePage extends Action
{
    public function handle(PageData $data): Page
    {
        return Page::create($data->toArray());
    }
}
