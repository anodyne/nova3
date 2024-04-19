<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Pages\Models\Page;

class UpdatePage
{
    use AsAction;

    public function handle(Page $page, array $data): Page
    {
        return tap($page)->update($data);
    }
}
