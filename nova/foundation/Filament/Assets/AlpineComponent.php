<?php

namespace Nova\Foundation\Filament\Assets;

use Filament\Support\Assets\AlpineComponent as FilamentAlpineComponentAsset;

class AlpineComponent extends FilamentAlpineComponentAsset
{
    public function getRelativePublicPath(): string
    {
        return 'dist/'.parent::getRelativePublicPath();
    }
}
