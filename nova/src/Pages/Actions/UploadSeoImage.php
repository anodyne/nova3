<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Pages\Models\Page;

class UploadSeoImage
{
    use AsAction;

    public function handle(Page $page, ?string $path = null): Page
    {
        if (filled($path)) {
            $page->addMedia($path)->toMediaCollection('seo-image');
        }

        return $page->refresh();
    }
}
