<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stats;

class SimpleStatsBlock extends StatsBlock
{
    public ?string $label = 'Stats - Simple';

    public string $rendered = 'pages.pages.blocks.stats.simple';

    public string $preview = 'pages.pages.blocks.stats.simple-preview';
}
