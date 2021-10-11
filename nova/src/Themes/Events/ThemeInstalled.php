<?php

declare(strict_types=1);

namespace Nova\Themes\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Themes\Models\Theme;

class ThemeInstalled
{
    use Dispatchable;
    use SerializesModels;

    public $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }
}
