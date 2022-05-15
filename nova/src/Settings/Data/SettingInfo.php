<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Spatie\LaravelData\Data;

class SettingInfo extends Data
{
    public function __construct(
        public ?string $action = null,
        public string $dto,
        public string $response,
    ) {
    }
}
