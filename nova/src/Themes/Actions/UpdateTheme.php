<?php

namespace Nova\Themes\Actions;

use Nova\Themes\Models\Theme;
use Nova\Themes\DataTransferObjects\ThemeData;

class UpdateTheme
{
    public function execute(Theme $theme, ThemeData $data): Theme
    {
        return tap($theme)
            ->update($data->except('variants')->toArray())
            ->refresh();
    }
}
