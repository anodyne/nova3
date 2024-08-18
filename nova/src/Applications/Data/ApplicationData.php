<?php

declare(strict_types=1);

namespace Nova\Applications\Data;

use Spatie\LaravelData\Data;

class ApplicationData extends Data
{
    public function __construct(
        public ?int $character_id,
        public ?int $user_id,
        public ?string $ip_address
    ) {}
}
