<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Themes\Data\ThemeData;
use Nova\Themes\Models\Theme;

class UpdateTheme
{
    use AsAction;

    public function handle(Theme $theme, ThemeData $data): Theme
    {
        return tap($theme)
            ->update(Arr::except($data->all(), 'variants'))
            ->refresh();
    }
}
