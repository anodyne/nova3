<?php

declare(strict_types=1);

namespace Nova\Reporting\Data;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Data;

class GameStats extends Data implements Arrayable
{
    public function __construct(
        public GameStatCategory $users,
        public GameStatCategory $characters,
        public GameStatCategory $stories,
        public GameStatCategory $posts,
        public GameStatCategory $averages
    ) {}
}
