<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

use Closure;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;

class EmailField extends Field
{
    const component = 'email';

    protected ?string $blockLabel = 'Email';

    protected string|Closure|null $preview = 'email-preview';

    public function attributesSchema(): array
    {
        return [
            TextInput::make('attrs.placeholder')
                ->label('Placeholder'),

            Section::make()
                ->schema([
                    Text::make(str('Email fields will include an `inputmode` of **email** to ensure software keyboards display the correct options.')->markdown()->toHtmlString())
                        ->color('gray'),
                ])
                ->compact()
                ->secondary(),
        ];
    }

    public function detailsSchema(): array
    {
        return [];
    }
}
