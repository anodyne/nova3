<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Assets;

use Filament\Support\Assets\Css as FilamentCssAsset;

class Css extends FilamentCssAsset
{
    public function getRelativePublicPath(): string
    {
        return 'dist/'.parent::getRelativePublicPath();
    }
}
