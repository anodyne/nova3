<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\CallToAction;

class SplitCallToActionBlock extends CallToActionBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('CTA - Split')
            ->identifier('cta-split')
            ->optionsModal(Settings\SplitCallToActionBlockSettings::class)
            ->renderedView('pages.pages.blocks.call-to-action.split')
            ->editorView('pages.pages.blocks.call-to-action.split-preview');
    }
}
