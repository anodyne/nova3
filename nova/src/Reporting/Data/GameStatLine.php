<?php

declare(strict_types=1);

namespace Nova\Reporting\Data;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Data;

class GameStatLine extends Data implements Arrayable
{
    public function __construct(
        public string $label,
        public ?string $currentTimeframe,
        public ?string $lastMonth,
        public ?string $thisMonth,
        public ?string $lifetime,
    ) {}
}
