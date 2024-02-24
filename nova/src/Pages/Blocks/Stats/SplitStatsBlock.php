<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stats;

class SplitStatsBlock extends StatsBlock
{
    public ?string $label = 'Stats - Split';

    public string $rendered = 'pages.pages.blocks.stats.split';

    public string $preview = 'pages.pages.blocks.stats.split-preview';
}
