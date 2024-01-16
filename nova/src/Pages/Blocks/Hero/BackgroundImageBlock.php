<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use FilamentTiptapEditor\TiptapBlock;

class BackgroundImageBlock extends TiptapBlock
{
    public ?string $label = 'Hero - Background Image';

    public string $preview = 'pages.pages.blocks.hero.background-image';

    public string $rendered = 'pages.pages.blocks.hero.background-image';

    public string $width = 'xl';

    public bool $slideOver = true;

    public ?string $icon = 'tabler-speakerphone';

    public function getFormSchema(): array
    {
        return [
            TextInput::make('heading'),
            Textarea::make('description'),
            Section::make('Primary button')->schema([
                TextInput::make('primary_button_label'),
                TextInput::make('primary_button_url')->url(),
            ]),
            Section::make('Secondary button')->schema([
                TextInput::make('secondary_button_label'),
                TextInput::make('secondary_button_url')->url(),
            ]),
        ];
    }
}
