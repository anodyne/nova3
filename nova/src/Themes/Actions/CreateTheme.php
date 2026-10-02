<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Themes\Data\ThemeData;
use Nova\Themes\Models\Theme;

class CreateTheme extends Action
{
    public function handle(ThemeData $data): Theme
    {
        return Theme::create($data->toArray());
    }
}
