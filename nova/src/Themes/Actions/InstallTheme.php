<?php

namespace Nova\Themes\Actions;

use Nova\Foundation\Action;
use Nova\Themes\Models\Theme;
use Nova\Themes\DataTransferObjects\ThemeData;

class InstallTheme extends Action
{
    public $errorMessage = 'There was a problem installing the theme';

    public function execute(ThemeData $data): Theme
    {
        return $this->call(function () use ($data) {
            return Theme::create($data->toArray());
        });
    }
}
