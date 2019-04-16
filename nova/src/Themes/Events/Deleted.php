<?php

namespace Nova\Themes\Events;

use Nova\Themes\Models\Theme;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class Deleted
{
    use Dispatchable, SerializesModels;

    public $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }
}
