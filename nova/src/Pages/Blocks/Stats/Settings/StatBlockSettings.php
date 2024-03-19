<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stats\Settings;

use Awcodes\Scribble\Enums\SlideDirection;
use Awcodes\Scribble\Livewire\ScribbleModal;
use Filament\Support\Enums\MaxWidth;

abstract class StatBlockSettings extends ScribbleModal
{
    public static function getSlideDirection(): SlideDirection
    {
        return SlideDirection::Right;
    }

    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::ExtraLarge;
    }

    protected function getStatOptions(): array
    {
        return [
            'all-time-posts' => 'All-time posts',
            'all-time-post-words' => 'All-time post words',
            'current-month-posts' => 'Posts this month',
            'current-month-post-words' => 'Post words this month',
            'current-year-posts' => 'Posts this year',
            'current-year-post-words' => 'Post words this year',
            'previous-month-posts' => 'Posts last month',
            'previous-month-post-words' => 'Post words last month',
            'previous-year-posts' => 'Posts last year',
            'previous-year-post-words' => 'Post words last year',
            'current-user-count' => 'Total active users',
            'current-character-count' => 'Total active characters',
        ];
    }
}
