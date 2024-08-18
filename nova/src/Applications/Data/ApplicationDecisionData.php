<?php

declare(strict_types=1);

namespace Nova\Applications\Data;

use Spatie\LaravelData\Data;

class ApplicationDecisionData extends Data
{
    public function __construct(
        public ?string $message,
        public ?int $rank_id = null,
        public array $positions = []
    ) {}
}
