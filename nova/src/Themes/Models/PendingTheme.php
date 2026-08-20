<?php

declare(strict_types=1);

namespace Nova\Themes\Models;

/**
 * @mixin IdeHelperPendingTheme
 */
class PendingTheme extends Theme
{
    protected $table = 'themes';

    public function getKey(): string
    {
        return $this->location;
    }
}
