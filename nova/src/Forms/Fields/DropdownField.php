<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

class DropdownField extends Field
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->icon('tabler-select')
            ->label('Dropdown')
            ->identifier('field-dropdown')
            ->optionsModal(Settings\DropdownFieldSettings::class)
            ->renderedView('pages.forms.fields.dropdown')
            ->editorView('pages.forms.fields.dropdown-preview');
    }
}
