<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Manifest;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;

class ManifestBlock extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('tabler-masks-theater')
            ->type(ToolType::Block)
            ->label('Character manifest')
            ->identifier('manifest')
            ->optionsModal(Settings\ManifestBlockSettings::class)
            ->renderedView('pages.pages.blocks.manifest.index')
            ->editorView('pages.pages.blocks.manifest.index-preview');
    }
}
