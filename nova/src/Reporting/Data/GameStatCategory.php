<?php

declare(strict_types=1);

namespace Nova\Reporting\Data;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Data;

class GameStatCategory extends Data implements Arrayable
{
    public function __construct(
        public string $label,
        public ?string $hint,
        public array $stats
    ) {}
}
