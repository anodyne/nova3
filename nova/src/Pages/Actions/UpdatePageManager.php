<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Pages\Models\Page;
use Nova\Pages\Requests\UpdatePageRequest;

class UpdatePageManager
{
    use AsAction;

    public function handle(Page $page, UpdatePageRequest $request): Page
    {
        $page = UpdatePage::run($page, $request->getPageData());

        $page = UploadSeoImage::run($page, $request->image_path);

        Cache::forget('nova.pages');

        return $page;
    }
}
