<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Pages\Data\PageData;
use Nova\Pages\Models\Page;

class DuplicatePage
{
    use AsAction;

    public function handle(Page $original, PageData $data): Page
    {
        $page = $original->replicate(['prefixed_id']);
        $page->forceFill($data->toArray());
        $page->save();

        BustPagesCache::run();
        RecachePages::run();

        activity()
            ->performedOn($original)
            ->withProperty('replica', $page->id)
            ->event('duplicated')
            ->log('duplicated');

        return $page->refresh();
    }
}
