<?php

declare(strict_types=1);

namespace Nova\Foundation\Data;

use Spatie\LaravelData\Data;

class DiscordSettings extends Data
{
    public function __construct(
        public ?string $webhook,
        public ?string $color,
    ) {
    }
}
