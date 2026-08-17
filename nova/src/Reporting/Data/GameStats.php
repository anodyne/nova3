<?php

declare(strict_types=1);

namespace Nova\Reporting\Data;

use Bag\Bag;

/**
 * @method static static from(GameStatCategory $users, GameStatCategory $characters, GameStatCategory $stories, GameStatCategory $posts, GameStatCategory $averages)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class GameStats extends Bag
{
    public function __construct(
        public GameStatCategory $users,
        public GameStatCategory $characters,
        public GameStatCategory $stories,
        public GameStatCategory $posts,
        public GameStatCategory $averages
    ) {}
}
