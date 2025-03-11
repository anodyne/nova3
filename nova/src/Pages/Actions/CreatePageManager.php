<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Pages\Models\Page;
use Nova\Pages\Requests\StorePageRequest;

class CreatePageManager
{
    use AsAction;

    public function handle(StorePageRequest $request): Page
    {
        return DB::transaction(function () use ($request) {
            $page = CreatePage::run($request->getPageData());

            $page = UploadSeoImage::run($page, $request->image_path);

            BustPagesCache::run();
            RecachePages::run();

            return $page;
        });
    }
}
