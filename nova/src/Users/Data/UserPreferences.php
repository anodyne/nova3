<?php

declare(strict_types=1);

namespace Nova\Users\Data;

use Spatie\LaravelData\Data;

class UserPreferences extends Data
{
    public function __construct(
        public ?string $timezone
    ) {
    }
}
