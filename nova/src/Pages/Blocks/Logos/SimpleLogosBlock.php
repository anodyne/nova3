<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Logos;

class SimpleLogosBlock extends LogosBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Logos - Simple')
            ->identifier('logos-simple')
            ->optionsModal(Settings\SimpleLogosBlockSettings::class)
            ->renderedView('pages.pages.blocks.logos.simple')
            ->editorView('pages.pages.blocks.logos.simple-preview');
    }
}
