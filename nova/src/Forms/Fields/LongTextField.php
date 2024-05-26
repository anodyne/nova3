<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

class LongTextField extends Field
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->icon('tabler-text-plus')
            ->label('Long text')
            ->identifier('field-long-text')
            ->optionsModal(Settings\LongTextFieldSettings::class)
            ->renderedView('pages.forms.fields.long-text')
            ->editorView('pages.forms.fields.long-text-preview');
    }
}
