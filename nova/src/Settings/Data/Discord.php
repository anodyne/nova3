<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Data;

class Discord extends Data implements Arrayable
{
    public function __construct(
        public ?string $color,
        public ?string $webhook,
    ) {
    }
}
