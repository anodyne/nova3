<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Pages\Data\PageBlocksData;
use Nova\Pages\Data\PageData;
use Nova\Pages\Models\Page;

class UpdatePage
{
    use AsAction;

    public function handle(Page $page, PageData|PageBlocksData $data): Page
    {
        $page = tap($page)->update($data->all());

        Cache::forget('nova.pages');

        return $page;
    }
}
