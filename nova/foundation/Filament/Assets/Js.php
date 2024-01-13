<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Assets;

use Filament\Support\Assets\Js as FilamentJsAsset;

class Js extends FilamentJsAsset
{
    public function getRelativePublicPath(): string
    {
        return 'dist/'.parent::getRelativePublicPath();
    }
}
