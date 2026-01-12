<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Features;

use Anodyne\TablerIcons\Tabler;
use Closure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Nova\Pages\Enums\BoxShadow;
use Nova\Pages\Enums\Radius;

class AlternatingFeatureBlock extends FeatureBlock
{
    const component = 'features.alternating';

    protected ?string $blockLabel = 'Features - Alternating';

    protected string|Closure|null $preview = 'features.alternating';

    public function blockSchema(): array
    {
        return [
            Section::make()
                ->heading('Features')
                ->description('Define the features you want to highlight with this block')
                ->icon(Tabler::Sparkles)
                ->columns(2)
                ->schema([
                    Select::make('block.image.radius')
                        ->label('Image radius')
                        ->options(Radius::class)
                        ->default(Radius::ThreeExtraLarge->value),
                    Select::make('block.image.shadow')
                        ->label('Image shadow')
                        ->options(BoxShadow::class)
                        ->default(BoxShadow::TwoExtraLarge->value),
                    Repeater::make('block.features')
                        ->hiddenLabel()
                        ->columnSpanFull()
                        ->schema([
                            RichEditor::make('content'),
                            FileUpload::make('image')
                                ->disk('media-pages')
                                ->directory((string) $this->getPageDesignerPage()),
                        ]),
                    Toggle::make('block.dark')
                        ->label('My block uses a dark background')
                        ->helperText('This will ensure that the colors of each feature will be better tuned to the background'),
                ]),
        ];
    }
}
