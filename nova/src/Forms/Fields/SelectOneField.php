<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

class SelectOneField extends Field
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->icon('tabler-circle-dot')
            ->label('Select one')
            ->identifier('field-select-one')
            ->optionsModal(Settings\SelectOneFieldSettings::class)
            ->renderedView('pages.forms.fields.select-one')
            ->editorView('pages.forms.fields.select-one-preview');
    }
}
