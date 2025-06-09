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
        if (is_null($path)) {
            $page->clearMediaCollection('seo-image');

            activity()
                ->performedOn($page)
                ->event('removed SEO image')
                ->log('removed SEO image');
        } else {
            $page->addMedia($path)->toMediaCollection('seo-image');

            activity()
                ->performedOn($page)
                ->event('uploaded SEO image')
                ->log('uploaded SEO image');
        }

        return $page->refresh();
    }
}
