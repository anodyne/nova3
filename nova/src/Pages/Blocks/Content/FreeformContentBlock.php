<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Content;

use Filament\Schemas\Components\Grid;
use Closure;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Nova\Pages\Blocks\Block as PageBuilderBlock;
use Nova\Pages\Enums\ProseSize;

class FreeformContentBlock extends PageBuilderBlock
{
    const component = 'content.index';

    protected string|Closure $section = 'Freeform content';

    protected ?string $blockLabel = 'Freeform content';

    protected string|Closure|null $preview = 'content.index';

    public function blockSchema(): array
    {
        return [
            Grid::make(2)->schema([
                Select::make('block.text-size')
                    ->label('Size')
                    ->options(ProseSize::class)
                    ->default(ProseSize::Base->value),
                ColorPicker::make('block.text-color')->label('Color'),
            ]),
            RichEditor::make('block.content'),
        ];
    }
}
