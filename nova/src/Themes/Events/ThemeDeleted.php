<?php

declare(strict_types=1);

namespace Nova\Themes\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Themes\Models\Theme;

class ThemeDeleted
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Theme $theme
    ) {
    }
}
