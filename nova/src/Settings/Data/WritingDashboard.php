<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Nova\Settings\Enums\PostingTarget;
use Spatie\LaravelData\Data;

class WritingDashboard extends Data implements Arrayable
{
    public function __construct(
        public Leaderboard $leaderboard,
        public PostingTarget $milestonesTarget
    ) {}
}
