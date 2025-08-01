<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

use Closure;
use Filament\Forms\Components\TextInput;

class ShortTextField extends Field
{
    const component = 'short-text';

    protected ?string $blockLabel = 'Short text';

    protected string|Closure|null $preview = 'short-text-preview';

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
