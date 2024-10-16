<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Themes\Data\ThemeData;
use Nova\Themes\Models\Theme;

class CreateTheme
{
    use AsAction;

    public function handle(ThemeData $data): Theme
    {
        return Theme::create($data->all());
    }
}
