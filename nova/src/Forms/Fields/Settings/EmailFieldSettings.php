<?php

declare(strict_types=1);

namespace Nova\Forms\Fields\Settings;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;

class EmailFieldSettings extends FieldSettings
{
    public ?string $header = 'Email field';

    public ?string $identifier = 'field-email';

    public function mount(): void
    {
        $this->form->fill([
            ...$this->getFormData(),
            'attributes' => $this->data['attributes'] ?? [
                'placeholder' => '',
            ],
        ]);
    }

    public function getFormFields(): array
    {
        return $this->formFields([
            Section::make('Field attributes')->schema([
                Placeholder::make('fieldId')
                    ->label('Field ID')
                    ->content('You do not need to specify an ID in the HTML attributes below since that’s already handled for you in the Field Info section.'),
                KeyValue::make('attributes')
                    ->label('HTML attributes')
                    ->helperText('Add any HTML attributes you want to your field')
                    ->addActionLabel('Add attribute')
                    ->keyLabel('Attribute'),
                Placeholder::make('additionalAttributes')
                    ->content(str('Email fields will include an `inputmode` of **email** to ensure software keyboards display the correct options.')->markdown()->toHtmlString()),
            ]),
        ]);
    }
}
