<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Logos;

class SplitLogosBlock extends LogosBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Logos - Split')
            ->identifier('logos-split')
            ->optionsModal(Settings\SplitLogosBlockSettings::class)
            ->renderedView('pages.pages.blocks.logos.split')
            ->editorView('pages.pages.blocks.logos.split-preview');
    }
}
