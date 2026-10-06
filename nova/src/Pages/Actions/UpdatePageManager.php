<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Foundation\Actions\Action;
use Nova\Pages\Models\Page;
use Nova\Pages\Requests\UpdatePageRequest;

class UpdatePageManager extends Action
{
    public function handle(Page $page, UpdatePageRequest $request): Page
    {
        return DB::transaction(function () use ($page, $request) {
            $page = UpdatePage::run($page, $request->getPageData());

            $page = UploadSeoImage::run($page, $request->image_path);

            BustPagesCache::run();
            RecachePages::run();

            DisableLinkedMenuItems::run($page);

            return $page;
        });
    }
}
