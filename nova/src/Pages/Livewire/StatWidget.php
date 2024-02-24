<?php

declare(strict_types=1);

namespace Nova\Pages\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Stories\Models\Post;
use Nova\Users\Models\User;

class StatWidget extends Component
{
    public ?string $identifier = null;

    public ?string $heading = null;

    public bool $dark = false;

    #[Computed]
    public function statValue(): string
    {
        return match ($this->identifier) {
            'all-time-posts' => number_format(Post::published()->count()),
            'all-time-post-words' => number_format((int) Post::published()->sum('word_count')),
            'current-month-posts' => number_format(Post::published()->currentMonth()->count()),
            'current-month-post-words' => number_format((int) Post::published()->currentMonth()->sum('word_count')),
            'current-year-posts' => number_format(Post::published()->currentYear()->count()),
            'current-year-post-words' => number_format((int) Post::published()->currentYear()->sum('word_count')),
            'previous-month-posts' => number_format(Post::published()->previousMonth()->count()),
            'previous-month-post-words' => number_format((int) Post::published()->previousMonth()->sum('word_count')),
            'previous-year-posts' => number_format(Post::published()->previousYear()->count()),
            'previous-year-post-words' => number_format((int) Post::published()->previousYear()->sum('word_count')),
            'current-user-count' => number_format(User::active()->count()),
            'current-character-count' => number_format(Character::active()->count()),
            default => '-'
        };
    }

    public function render()
    {
        return view('pages.pages.livewire.stat-widget', [
            'value' => $this->statValue,
        ]);
    }
}
