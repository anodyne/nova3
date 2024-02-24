<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\CallToAction;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use FilamentTiptapEditor\TiptapBlock;
use Nova\Pages\Blocks\FormSchema;

abstract class CallToActionBlock extends TiptapBlock
{
    public string $width = 'xl';

    public bool $slideOver = true;

    public ?string $icon = 'tabler-speakerphone';

    public function getFormSchema(): array
    {
        return [
            TextInput::make('heading'),
            Section::make('Primary button')->schema([
                TextInput::make('primaryButtonLabel'),
                TextInput::make('primaryButtonUrl')->url(),
            ]),
            Section::make('Secondary button')->schema([
                TextInput::make('secondaryButtonLabel'),
                TextInput::make('secondaryButtonUrl')->url(),
            ]),
            ...FormSchema::background(),
            Toggle::make('dark')->label('Invert text colors for dark backgrounds'),
        ];
    }
}
