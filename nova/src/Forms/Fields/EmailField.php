<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

use Closure;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;

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

            Placeholder::make('additionalAttributes')
                ->content(str('Email fields will include an `inputmode` of **email** to ensure software keyboards display the correct options.')->markdown()->toHtmlString()),
        ];
    }

    public function detailsSchema(): array
    {
        return [];
    }
}
