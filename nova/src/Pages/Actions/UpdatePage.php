<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Pages\Data\PageBlocksData;
use Nova\Pages\Data\PageData;
use Nova\Pages\Models\Page;

class UpdatePage extends Action
{
    public function handle(Page $page, PageData|PageBlocksData $data): Page
    {
        return tap($page)->update($data->toArray());
    }
}
