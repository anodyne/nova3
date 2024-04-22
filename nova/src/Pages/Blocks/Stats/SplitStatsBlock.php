<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stats;

class SplitStatsBlock extends StatsBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Stats - Split')
            ->identifier('stats-split')
            ->optionsModal(Settings\SplitStatsBlockSettings::class)
            ->renderedView('pages.pages.blocks.stats.split')
            ->editorView('pages.pages.blocks.stats.split-preview');
    }
}
