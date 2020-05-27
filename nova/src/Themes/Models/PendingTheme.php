<?php

namespace Nova\Themes\Models;

class PendingTheme extends Theme
{
    protected $table = 'themes';

    public function getKey()
    {
        return $this->location;
    }
}
