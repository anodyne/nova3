<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

class EmailField extends Field
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->icon('tabler-at')
            ->label('Email address')
            ->identifier('field-email')
            ->optionsModal(Settings\EmailFieldSettings::class)
            ->renderedView('pages.forms.fields.email')
            ->editorView('pages.forms.fields.email-preview');
    }
}
