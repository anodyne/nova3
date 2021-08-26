<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Nova\Themes\DataTransferObjects\ThemeData;
use Nova\Themes\Models\Theme;

class UpdateTheme
{
    public function execute(Theme $theme, ThemeData $data): Theme
    {
        return tap($theme)
            ->update($data->except('variants')->toArray())
            ->refresh();
    }
}
