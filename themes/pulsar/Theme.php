<?php

declare(strict_types=1);

namespace Themes\pulsar;

use Nova\Themes\BaseTheme;

class Theme extends BaseTheme
{
    public $location = 'pulsar';

    public $iconSet = 'feather';

    /**
     * This is where you can add data to every view that gets rendered through
     * your theme. For example, if you wanted to display some data that's on
     * your layout file, you can define that data here for use in the file.
     */
    public function prepareData(): array
    {
        return [];
    }
}
