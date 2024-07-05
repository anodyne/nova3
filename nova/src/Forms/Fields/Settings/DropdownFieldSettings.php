<?php

declare(strict_types=1);

namespace Nova\Forms\Fields\Settings;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;

class DropdownFieldSettings extends FieldSettings
{
    public ?string $header = 'Dropdown field';

    public ?string $identifier = 'field-dropdown';

    public function mount(): void
    {
        $this->form->fill([
            ...$this->getFormData(),
            'options' => $this->data['options'] ?? [],
            'attributes' => $this->data['attributes'] ?? [
                'placeholder' => '',
            ],
        ]);
    }

    public function getFormFields(): array
    {
        return $this->formFields([
            Section::make('Field attributes')->schema([
                KeyValue::make('attributes')
                    ->label('HTML attributes')
                    ->helperText('Add any HTML attributes you want to your field')
                    ->addActionLabel('Add attribute')
                    ->keyLabel('Attribute'),
            ]),
            Section::make('Options')->schema([
                KeyValue::make('options')
                    ->hiddenLabel()
                    ->helperText('If you specify a placeholder attribute, it will be used as the first option in the select menu')
                    ->addActionLabel('Add option')
                    ->keyLabel('Value')
                    ->valueLabel('Text'),
            ]),
        ]);
    }
}
