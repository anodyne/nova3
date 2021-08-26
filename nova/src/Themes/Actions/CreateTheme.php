<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Nova\Themes\DataTransferObjects\ThemeData;
use Nova\Themes\Models\Theme;

class CreateTheme
{
    public function execute(ThemeData $data): Theme
    {
        return Theme::create(
            $data->except('variants')->toArray()
        );
    }
}
