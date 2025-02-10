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
        $replica = $original->replicate(['prefixed_id']);
        $replica->forceFill($data->toArray());
        $replica->save();

        BustPagesCache::run();
        RecachePages::run();

        activity()
            ->performedOn($original)
            ->withProperty('replica', $replica->id)
            ->event('duplicated')
            ->log('duplicated');

        return $replica->refresh();
    }
}
