<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

use Closure;
use Filament\Forms\Components\KeyValue;

class KeyValueField extends Field
{
    const component = 'key-value';

    protected ?string $blockLabel = 'Key-Value';

    protected string|Closure|null $preview = 'key-value-preview';

    protected bool $showOtherHtmlAttributesField = false;

    public function attributesSchema(): array
    {
        return [
            KeyValue::make('attrs.defaults')
                ->label('Defaults')
                ->helperText('You can set defaults for the field that users can fill in')
                ->keyLabel('Label'),
        ];
    }

    public function detailsSchema(): array
    {
        return [];
    }
}
