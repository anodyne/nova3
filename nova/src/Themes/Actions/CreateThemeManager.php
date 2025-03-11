<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Themes\Models\Theme;
use Nova\Themes\Requests\StoreThemeRequest;

class CreateThemeManager
{
    use AsAction;

    public function handle(StoreThemeRequest $request): Theme
    {
        return DB::transaction(function () use ($request) {
            $theme = CreateTheme::run($request->getThemeData());

            SetupThemeDirectory::run($request->getThemeData());

            return $theme;
        });
    }
}
