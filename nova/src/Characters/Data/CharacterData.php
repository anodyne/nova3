<?php

declare(strict_types=1);

namespace Nova\Characters\Data;

use Spatie\LaravelData\Data;

class CharacterData extends Data
{
    public function __construct(
        public string $name,
        public ?int $rank_id
    ) {
    }
}
