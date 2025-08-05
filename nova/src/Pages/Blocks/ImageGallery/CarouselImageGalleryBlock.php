<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ImageGallery;

use Closure;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Nova\Foundation\Icons\Icon;
use Nova\Pages\Enums\BoxShadow;
use Nova\Pages\Enums\Radius;

class CarouselImageGalleryBlock extends ImageGalleryBlock
{
    const component = 'image-gallery.carousel';

    protected ?string $blockLabel = 'Image Gallery - Carousel';

    protected string|Closure|null $preview = 'image-gallery.carousel';

    public function blockSchema(): array
    {
        return [
            Section::make()
                ->heading('Carousel options')
                ->description('Customize how the image gallery carousel behaves')
                ->icon(Icon::Preferences)
                ->columns(2)
                ->schema([
                    Select::make('block.carousel.autoplay')
                        ->label('Autoplay speed')
                        ->options([
                            '0' => 'Off',
                            '5000' => 'Fast',
                            '7500' => 'Normal',
                            '10000' => 'Slow',
                        ]),
                    ToggleButtons::make('block.carousel.arrows')
                        ->label('Use arrows')
                        ->inline()
                        ->options([
                            'yes' => 'Yes',
                            'no' => 'No',
                        ])
                        ->default('yes'),
                    Select::make('block.carousel.radius')
                        ->label('Corner radius')
                        ->options(Radius::class)
                        ->default(Radius::None->value),
                    Select::make('block.carousel.shadow')
                        ->label('Shadow')
                        ->options(BoxShadow::class)
                        ->default(BoxShadow::None->value),
                ]),
            ...$this->galleryBlock(),
        ];
    }
}
