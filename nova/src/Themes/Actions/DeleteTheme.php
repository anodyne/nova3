<?php

namespace Nova\Themes\Actions;

use Nova\Foundation\Action;
use Nova\Themes\Models\Theme;

class DeleteTheme extends Action
{
    public $errorMessage = 'There was a problem deleting the theme';

    public function execute(Theme $theme): Theme
    {
        return $this->call(function () use ($theme) {
            return tap($theme)->delete();
        });
    }
}
