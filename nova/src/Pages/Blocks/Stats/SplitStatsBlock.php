<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stats;

use Closure;

class SplitStatsBlock extends StatsBlock
{
    const component = 'stats.split';

    protected ?string $blockLabel = 'Stats - Split block';

    protected string|Closure|null $preview = 'stats.split';
}
