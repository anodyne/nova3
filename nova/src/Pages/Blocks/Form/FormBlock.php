<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Form;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;

class FormBlock extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('tabler-forms')
            ->type(ToolType::Block)
            ->label('Form')
            ->identifier('form')
            ->optionsModal(Settings\FormBlockSettings::class)
            ->renderedView('pages.pages.blocks.form.index')
            ->editorView('pages.pages.blocks.form.index-preview');
    }
}
