<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stats;

use Closure;

class SimpleStatsBlock extends StatsBlock
{
    const component = 'stats.simple';

    protected ?string $blockLabel = 'Stats - Simple block';

    protected string|Closure|null $preview = 'stats.simple';
}
