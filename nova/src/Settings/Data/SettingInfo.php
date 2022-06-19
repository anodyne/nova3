<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Spatie\LaravelData\Data;

class SettingInfo extends Data
{
    public function __construct(
        public string $dto,
        public string $response,
        public ?string $action = null
    ) {
    }
}
