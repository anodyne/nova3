<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class EnvironmentConfiguration extends Data implements Arrayable
{
    public function __construct(
        public ?string $url,
        public ?string $environment,
        public ?int $debugMode
    ) {}

    public function debugMode(): string
    {
        return match ($this->debugMode) {
            1 => 'true',
            default => 'false',
        };
    }
}
