<?php

declare(strict_types=1);

namespace Nova\Forms\Data;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class FormData extends Data
{
    public function __construct(
        public string $name,
        public string $key,
        public string $type,
        public ?string $description,
        public ?FormOptions $options,
    ) {
    }
}
