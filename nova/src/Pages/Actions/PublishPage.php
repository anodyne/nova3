<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Pages\Models\Page;

class PublishPage
{
    use AsAction;

    public function handle(Page $page): Page
    {
        activity()->withoutLogs(function () use ($page): void {
            $page->published_blocks = $page->blocks;
            $page->published_at = now();
            $page->save();
        });

        activity()
            ->performedOn($page)
            ->event('published')
            ->log('published');

        return $page->refresh();
    }
}
