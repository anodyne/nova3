<?php

declare(strict_types=1);

namespace Nova\Applications\Data;

use Bag\Bag;

readonly class ApplicationDecisionData extends Bag
{
    public function __construct(
        public ?string $message,
        public ?int $rank_id = null,
        public array $positions = []
    ) {}
}
