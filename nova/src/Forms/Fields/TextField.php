<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

class TextField extends Field
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Text field')
            ->identifier('field-text')
            ->optionsModal(Settings\TextFieldSettings::class)
            ->renderedView('pages.forms.fields.text')
            ->editorView('pages.forms.fields.text-preview');
    }
}
