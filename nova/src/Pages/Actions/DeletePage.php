<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Pages\Models\Page;

class DeletePage
{
    use AsAction;

    public function handle(Page $page): Page
    {
        $page = tap($page)->delete();

        Cache::forget('nova.pages');

        return $page;
    }
}
