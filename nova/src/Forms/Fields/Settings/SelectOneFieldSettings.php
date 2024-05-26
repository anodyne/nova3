<?php

declare(strict_types=1);

namespace Nova\Forms\Fields\Settings;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class SelectOneFieldSettings extends FieldSettings
{
    public ?string $header = 'Select One field';

    public ?string $identifier = 'field-select-one';

    public function mount(): void
    {
        $this->form->fill([
            ...$this->getFormData(),
            'options' => $this->data['options'] ?? [],
        ]);
    }

    public function getFormFields(): array
    {
        return $this->formFields([
            Section::make('Options')->schema([
                Placeholder::make('fieldId')
                    ->label('Field ID')
                    ->content('You do not need to specify an ID in the HTML attributes below since that’s already handled for you in the Field Info section.'),
                Repeater::make('options')
                    ->hiddenLabel()
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
            ]),
        ]);
    }
}
