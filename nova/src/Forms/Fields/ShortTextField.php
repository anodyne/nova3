<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

class ShortTextField extends Field
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->icon('tabler-forms')
            ->label('Short text')
            ->identifier('field-short-text')
            ->optionsModal(Settings\ShortTextFieldSettings::class)
            ->renderedView('pages.forms.fields.short-text')
            ->editorView('pages.forms.fields.short-text-preview');
    }
}
