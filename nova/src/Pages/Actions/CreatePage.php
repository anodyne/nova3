<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Pages\Data\PageData;
use Nova\Pages\Models\Page;

class CreatePage
{
    use AsAction;

    public function handle(PageData $data): Page
    {
        $page = Page::create($data->all());

        Cache::forget('nova.pages');

        return $page;
    }
}
