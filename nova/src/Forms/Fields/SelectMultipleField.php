<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

class SelectMultipleField extends Field
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->icon('tabler-square-check')
            ->label('Select multiple')
            ->identifier('field-select-multiple')
            ->optionsModal(Settings\SelectFieldSettings::class)
            ->renderedView('pages.forms.fields.radio');
    }
}
