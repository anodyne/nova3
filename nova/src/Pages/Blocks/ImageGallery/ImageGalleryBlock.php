<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ImageGallery;

use Closure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Nova\Pages\Blocks\Block as PageBuilderBlock;

abstract class ImageGalleryBlock extends PageBuilderBlock
{
    protected string|Closure $section = 'Image Gallery';

    protected function galleryBlock(): array
    {
        return [
            Section::make()
                ->heading('Images')
                ->description('Add images to your gallery')
                ->icon(iconName('image'))
                ->schema([
                    Repeater::make('block.images')
                        ->hiddenLabel()
                        ->schema([
                            FileUpload::make('src')
                                ->label('Image')
                                ->disk('media-pages')
                                ->directory((string) $this->getPageDesignerPage()),
                            TextInput::make('alt')
                                ->label('Image alt text'),
                            TextInput::make('heading')
                                ->label('Caption heading'),
                            Textarea::make('description')
                                ->label('Caption description'),
                        ]),
                ]),
        ];
    }
}
