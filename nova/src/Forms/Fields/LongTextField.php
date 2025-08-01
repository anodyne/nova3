<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

use Closure;
use Filament\Forms\Components\TextInput;

class LongTextField extends Field
{
    const component = 'long-text';

    protected ?string $blockLabel = 'Long text';

    protected string|Closure|null $preview = 'long-text-preview';

    public function attributesSchema(): array
    {
        return [
            TextInput::make('attrs.placeholder')
                ->label('Placeholder'),

            TextInput::make('attrs.rows')
                ->label('Rows')
                ->numeric()
                ->default(5),
        ];
    }

    public function detailsSchema(): array
    {
        return [];
    }
}
