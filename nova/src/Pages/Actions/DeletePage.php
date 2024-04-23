<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Pages\Models\Page;

class DeletePage
{
    use AsAction;

    public function handle(Page $page): Page
    {
        return tap($page)->delete();
    }
}
