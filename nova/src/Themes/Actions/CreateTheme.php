<?php

namespace Nova\Themes\Actions;

use Nova\Themes\Models\Theme;
use Nova\Themes\DataTransferObjects\ThemeData;

class CreateTheme
{
    public function execute(ThemeData $data): Theme
    {
        return Theme::create(
            $data->except('variants')->toArray()
        );
    }
}
