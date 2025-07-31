<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

use Closure;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;

class DropdownField extends Field
{
    const component = 'dropdown';

    protected ?string $blockLabel = 'Dropdown';

    protected string|Closure|null $preview = 'dropdown-preview';

    public function attributesSchema(): array
    {
        return [
            TextInput::make('attrs.placeholder')
                ->label('Placeholder'),

            KeyValue::make('attrs.options')
                ->label('Options')
                ->helperText('If you specify a placeholder attribute, it will be used as the first option in the select menu')
                ->addActionLabel('Add option')
                ->keyLabel('Value')
                ->valueLabel('Text'),
        ];
    }

    public function detailsSchema(): array
    {
        return [];
    }
}
