<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Illuminate\Support\Arr;
use Nova\Foundation\Actions\Action;
use Nova\Themes\Data\ThemeData;
use Nova\Themes\Models\Theme;

class UpdateTheme extends Action
{
    public function handle(Theme $theme, ThemeData $data): Theme
    {
        return tap($theme)
            ->update(Arr::except($data->toArray(), ['settings']))
            ->refresh();
    }
}
