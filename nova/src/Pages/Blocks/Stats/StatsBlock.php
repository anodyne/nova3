<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stats;

use FilamentTiptapEditor\TiptapBlock;

abstract class StatsBlock extends TiptapBlock
{
    public int $columns = 3;

    public string $width = 'xl';

    public bool $slideOver = true;

    public ?string $icon = 'tabler-speakerphone';

    protected function getStatOptions(): array
    {
        return [
            'all-time-posts' => 'All-time posts',
            'all-time-post-words' => 'All-time post words',
            'current-month-posts' => 'Posts this month',
            'current-month-post-words' => 'Post words this month',
            'previous-month-posts' => 'Posts last month',
            'previous-month-post-words' => 'Post words last month',
            'current-user-count' => 'Total active users',
            'current-character-count' => 'Total active characters',
        ];
    }

    protected function getStat(string $key)
    {
        return match ($key) {
            default => '-'
        };
    }
}
