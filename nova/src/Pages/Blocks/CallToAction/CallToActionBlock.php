<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\CallToAction;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use FilamentTiptapEditor\TiptapBlock;

abstract class CallToActionBlock extends TiptapBlock
{
    public string $width = 'xl';

    public bool $slideOver = true;

    public ?string $icon = 'tabler-speakerphone';

    public function getFormSchema(): array
    {
        return [
            TextInput::make('heading'),
            Textarea::make('description'),
            Toggle::make('fullWidth'),
            Section::make('Primary button')->schema([
                TextInput::make('primaryButtonLabel'),
                TextInput::make('primaryButtonUrl')->url(),
            ]),
            Section::make('Secondary button')->schema([
                TextInput::make('secondaryButtonLabel'),
                TextInput::make('secondaryButtonUrl')->url(),
            ]),
        ];
    }
}
