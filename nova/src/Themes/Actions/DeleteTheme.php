<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Themes\Models\Theme;

class DeleteTheme extends Action
{
    public function handle(Theme $theme): Theme
    {
        return tap($theme)->delete();
    }
}
