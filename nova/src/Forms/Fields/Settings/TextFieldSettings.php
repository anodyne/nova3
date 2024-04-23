<?php

declare(strict_types=1);

namespace Nova\Forms\Fields\Settings;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class TextFieldSettings extends FieldSettings
{
    public ?string $header = 'Text field';

    public ?string $identifier = 'field-text';

    public function mount(): void
    {
        $this->form->fill([
            ...$this->getFormData(),
            'type' => $this->data['type'] ?? 'text',
            'attributes' => $this->data['attributes'] ?? [
                'placeholder' => '',
            ],
            'required' => $this->data['required'] ?? false,
        ]);
    }

    public function getFormFields(): array
    {
        return [
            ...parent::getFormFields(),
            Select::make('type')->options([
                'text' => 'Text',
                'email' => 'Email',
                'number' => 'Number',
                'password' => 'Password',
            ]),
            KeyValue::make('attributes')
                ->label('HTML attributes')
                ->helperText('Add any HTML attributes you want to your field')
                ->addActionLabel('Add attribute')
                ->keyLabel('Attribute'),
            Toggle::make('required')
                ->label('Required to have a value')
                ->default(function () {
                    return true;
                }),
        ];
    }
}
