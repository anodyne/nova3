<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Logos;

use Closure;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Nova\Foundation\Icons\Icon;
use Nova\Pages\Blocks\Block as PageBuilderBlock;

abstract class LogosBlock extends PageBuilderBlock
{
    protected string|Closure $section = 'Logos';

    public function blockSchema(): array
    {
        return [
            Section::make()
                ->heading('Logo(s)')
                ->description('Upload the logo(s) you want to display in the block')
                ->icon(Icon::Photo)
                ->schema([
                    Repeater::make('block.logos')
                        ->hiddenLabel()
                        ->schema([
                            TextInput::make('url')
                                ->label('URL')
                                ->url(),
                            Grid::make(2)->schema([
                                TextInput::make('text'),
                                ColorPicker::make('text-color')->label('Color'),
                            ]),
                            FileUpload::make('image')
                                ->disk('media-pages')
                                ->directory((string) $this->getPageDesignerPage()),
                        ]),
                ]),
        ];
    }
}
