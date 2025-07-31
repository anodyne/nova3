<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

use Closure;
use Filament\Forms\Components\TextInput;

class DateField extends Field
{
    const component = 'date';

    protected ?string $blockLabel = 'Date';

    protected string|Closure|null $preview = 'date-preview';

    public function attributesSchema(): array
    {
        return [
            TextInput::make('attrs.placeholder')
                ->label('Placeholder'),
        ];
    }

    public function detailsSchema(): array
    {
        return [];
    }
}
