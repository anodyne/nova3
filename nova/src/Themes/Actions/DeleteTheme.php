<?php

namespace Nova\Themes\Actions;

use Nova\Themes\Models\Theme;

class DeleteTheme
{
    public function execute(Theme $theme)
    {
        return tap($theme, function ($theme) {
            $theme->delete();
        });
    }
}
