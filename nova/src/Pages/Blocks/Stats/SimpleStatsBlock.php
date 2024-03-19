<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stats;

class SimpleStatsBlock extends StatsBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Stats - Simple')
            ->identifier('stats-simple')
            ->optionsModal(Settings\SimpleStatsBlockSettings::class)
            ->renderedView('pages.pages.blocks.stats.simple')
            ->editorView('pages.pages.blocks.stats.simple-preview');
    }
}
