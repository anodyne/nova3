<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stories;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use FilamentTiptapEditor\TiptapBlock;

abstract class StoriesBlock extends TiptapBlock
{
    public string $width = 'xl';

    public bool $slideOver = true;

    public ?string $icon = 'tabler-books';

    public function getFormSchema(): array
    {
        return [
            Section::make('Intro')->schema([
                TextInput::make('heading'),
                Textarea::make('description'),
                Radio::make('orientation')
                    ->options([
                        'center' => 'Center',
                        'left' => 'Left',
                        'right' => 'Right',
                    ])
                    ->default('center'),
            ]),
        ];
    }
}
