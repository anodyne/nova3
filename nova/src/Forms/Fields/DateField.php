<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

class DateField extends Field
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->icon('tabler-calendar')
            ->label('Date')
            ->identifier('field-date')
            ->optionsModal(Settings\DateFieldSettings::class)
            ->renderedView('pages.forms.fields.date')
            ->editorView('pages.forms.fields.date-preview');
    }
}
