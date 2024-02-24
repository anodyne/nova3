<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\LogoCloud;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use FilamentTiptapEditor\TiptapBlock;
use Nova\Pages\Blocks\FormSchema;

abstract class LogoCloudBlock extends TiptapBlock
{
    public string $width = 'xl';

    public bool $slideOver = true;

    public ?string $icon = 'tabler-library-photo';

    public bool $useDescription = true;

    public function getFormSchema(): array
    {
        return [
            TextInput::make('heading'),
            Textarea::make('description')->visible($this->useDescription),
            ...FormSchema::background(),
            Toggle::make('dark')->label('Invert text colors for dark backgrounds'),
            Repeater::make('logos')
                ->schema([
                    TextInput::make('url')
                        ->label('URL')
                        ->url(),
                    FileUpload::make('image')
                        ->disk('media')
                        ->directory('pages'),
                ]),
        ];
    }
}
