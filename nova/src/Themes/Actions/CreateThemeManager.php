<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Themes\Data\ThemeData;
use Nova\Themes\Models\Theme;

class CreateThemeManager
{
    use AsAction;

    public function handle(Request $request): Theme
    {
        $theme = CreateTheme::run(
            $data = ThemeData::from($request)
        );

        SetupThemeDirectory::run($data);

        return $theme;
    }
}
