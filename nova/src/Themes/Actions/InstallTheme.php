<?php

namespace Nova\Themes\Actions;

use Nova\Themes\Models\Theme;
use Nova\Themes\DataTransferObjects\ThemeData;

class InstallTheme
{
    public function execute(ThemeData $data)
    {
        return Theme::create($data->toArray());
    }
}
