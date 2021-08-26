<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Nova\Themes\Models\Theme;

class DeleteTheme
{
    public function execute(Theme $theme): Theme
    {
        return tap($theme)->delete();
    }
}
