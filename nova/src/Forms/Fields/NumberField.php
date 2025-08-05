<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

use Closure;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;

class NumberField extends Field
{
    const component = 'number';

    protected ?string $blockLabel = 'Number';

    protected string|Closure|null $preview = 'number-preview';

    public function attributesSchema(): array
    {
        return [
            TextInput::make('attrs.placeholder')
                ->label('Placeholder'),

            Section::make()
                ->schema([
                    Text::make(str('Number fields will include an `inputmode` of **decimal** to ensure software keyboards display the correct options.')->markdown()->toHtmlString())
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
