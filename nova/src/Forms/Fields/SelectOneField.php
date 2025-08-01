<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

use Closure;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class SelectOneField extends Field
{
    const component = 'select-one';

    protected ?string $blockLabel = 'Select one';

    protected string|Closure|null $preview = 'select-one-preview';

    protected bool $showOtherHtmlAttributesField = false;

    public function attributesSchema(): array
    {
        return [
            Repeater::make('attrs.options')
                ->label('Options')
                ->schema([
                    TextInput::make('label'),

                    Textarea::make('description')->rows(5),

                    TextInput::make('value'),

                    KeyValue::make('attributes')
                        ->label('HTML attributes')
                        ->helperText('Add any HTML attributes you want to your field')
                        ->addActionLabel('Add attribute')
                        ->keyLabel('Attribute'),
                ]),
        ];
    }

    public function detailsSchema(): array
    {
        return [];
    }
}
