<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\CallToAction;

class SimpleCallToActionBlock extends CallToActionBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('CTA - Simple')
            ->identifier('cta-simple')
            ->optionsModal(Settings\SimpleCallToActionBlockSettings::class)
            ->renderedView('pages.pages.blocks.call-to-action.simple')
            ->editorView('pages.pages.blocks.call-to-action.simple-preview');
    }
}
