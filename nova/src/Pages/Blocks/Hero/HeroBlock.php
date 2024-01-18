<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use FilamentTiptapEditor\TiptapBlock;

abstract class HeroBlock extends TiptapBlock
{
    public string $width = 'xl';

    public bool $slideOver = true;

    public ?string $icon = 'tabler-speakerphone';

    public function getFormSchema(): array
    {
        return [
            TextInput::make('heading'),
            Textarea::make('description'),
            Section::make('Primary button')->schema([
                TextInput::make('primaryButtonLabel'),
                TextInput::make('primaryButtonUrl')
                    ->label('Primary button URL')
                    ->url(),
            ]),
            Section::make('Secondary button')->schema([
                TextInput::make('secondaryButtonLabel'),
                TextInput::make('secondaryButtonUrl')
                    ->label('Secondary button URL')
                    ->url(),
            ]),
        ];
    }
}
