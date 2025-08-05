<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ImageGallery;

use Closure;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Nova\Foundation\Icons\Icon;
use Nova\Pages\Enums\BoxShadow;
use Nova\Pages\Enums\Radius;

class ThumbnailImageGalleryBlock extends ImageGalleryBlock
{
    const component = 'image-gallery.thumbnail';

    protected ?string $blockLabel = 'Image Gallery - Thumbnail';

    protected string|Closure|null $preview = 'image-gallery.thumbnail';

    public function blockSchema(): array
    {
        return [
            Section::make()
                ->heading('Options')
                ->description('Set the display options for the gallery')
                ->icon(Icon::Preferences)
                ->columns(2)
                ->schema([
                    Select::make('block.options.radius')
                        ->label('Corner radius')
                        ->options(Radius::class)
                        ->default(Radius::None->value),
                    Select::make('block.options.shadow')
                        ->label('Shadow')
                        ->options(BoxShadow::class)
                        ->default(BoxShadow::None->value),
                ]),
            ...$this->galleryBlock(),
        ];
    }
}
