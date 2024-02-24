<?php

declare(strict_types=1);

namespace Themes\Pulsar;

use Filament\Forms\Components\ColorPicker;
use Nova\Themes\BaseTheme;

class Theme extends BaseTheme
{
    public $location = 'Pulsar';

    public function settingsForm(): array
    {
        return [
            ColorPicker::make('accentColor'),
        ];
    }
}
