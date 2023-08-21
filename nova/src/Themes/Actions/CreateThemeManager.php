<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Themes\Models\Theme;
use Nova\Themes\Requests\StoreThemeRequest;

class CreateThemeManager
{
    use AsAction;

    public function handle(StoreThemeRequest $request): Theme
    {
        $theme = CreateTheme::run($request->getThemeData());

        SetupThemeDirectory::run($request->getThemeData());

        return $theme;
    }
}
