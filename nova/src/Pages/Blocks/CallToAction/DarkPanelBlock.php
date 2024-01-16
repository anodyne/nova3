<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\CallToAction;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;

class DarkPanelBlock extends CallToActionBlock
{
    public ?string $label = 'CTA - Dark Panel';

    public string $preview = 'pages.pages.blocks.call-to-action.dark-panel';

    public string $rendered = 'pages.pages.blocks.call-to-action.dark-panel';

    public function getFormSchema(): array
    {
        return array_merge(
            parent::getFormSchema(),
            [
                Section::make('Colors')->schema([
                    ColorPicker::make('darkShade'),
                    ColorPicker::make('lightShade'),
                ]),
            ]
        );
    }
}
