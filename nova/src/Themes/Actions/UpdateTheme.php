<?php

namespace Nova\Themes\Actions;

use Nova\Foundation\Action;
use Nova\Themes\Models\Theme;
use Nova\Themes\DataTransferObjects\ThemeData;

class UpdateTheme extends Action
{
    public $errorMessage = 'There was a problem updating the theme';

    public function execute(Theme $theme, ThemeData $data): Theme
    {
        return $this->call(function () use ($theme, $data) {
            return tap($theme)->update($data->toArray())->refresh();
        });
    }
}
