<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero;

use Anodyne\TablerIcons\Tabler;
use Closure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Nova\Pages\Enums\BoxShadow;
use Nova\Pages\Enums\MediaType;
use Nova\Pages\Enums\Radius;

class SplitHeroBlock extends HeroBlock
{
    const component = 'hero.split';

    protected ?string $blockLabel = 'Hero - Split';

    protected string|Closure|null $preview = 'hero.split';

    public function blockSchema(): array
    {
        return [
            ...$this->buttonsRepeater(),
            Section::make('block.media')
                ->heading('Media')
                ->description('Customize the media that you want displayed for the block')
                ->icon(Tabler::PhotoVideo)
                ->schema([
                    ToggleButtons::make('block.media.type')
                        ->label('Media type')
                        ->inline()
                        ->options(MediaType::class)
                        ->default(MediaType::None->value)
                        ->live(),
                    Grid::make(2)
                        ->schema([
                            ToggleButtons::make('block.media.orientation')
                                ->label('Orientation')
                                ->options([
                                    'right' => 'Right',
                                    'left' => 'Left',
                                ])
                                ->inline()
                                ->default('right')
                                ->columnSpanFull(),
                            Select::make('block.media.radius')
                                ->options(Radius::class)
                                ->default(Radius::None->value),
                            Select::make('block.media.shadow')
                                ->options(BoxShadow::class)
                                ->default(BoxShadow::None->value),
                        ])
                        ->hidden(fn (Get $get): bool => $get('block.media.type') === MediaType::None->value),
                    FileUpload::make('block.media.image')
                        ->label('Image')
                        ->disk('media-pages')
                        ->directory((string) $this->getPageDesignerPage())
                        ->visible(fn (Get $get): bool => $get('block.media.type') === MediaType::Image->value),
                    TextInput::make('block.media.video')
                        ->label('Video URL')
                        ->url()
                        ->visible(fn (Get $get): bool => $get('block.media.type') === MediaType::Video->value),
                ]),
        ];
    }
}
