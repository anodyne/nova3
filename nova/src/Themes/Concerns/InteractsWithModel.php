<?php

namespace Nova\Themes\Concerns;

use Nova\Themes\Theme;

trait InteractsWithModel
{
    /**
     * Get the model for the theme.
     *
     * @return \Nova\Themes\Theme
     */
    public function getModel()
    {
        return Theme::location($this->location)->firstOrFail();
    }
}