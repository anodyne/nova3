<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Themes\Models\Theme;

class DeleteTheme
{
    use AsAction;

    public function handle(Theme $theme): Theme
    {
        return tap($theme)->delete();
    }
}
