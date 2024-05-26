<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

class NumberField extends Field
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->icon('tabler-number-123')
            ->label('Number')
            ->identifier('field-number')
            ->optionsModal(Settings\NumberFieldSettings::class)
            ->renderedView('pages.forms.fields.number')
            ->editorView('pages.forms.fields.number-preview');
    }
}
