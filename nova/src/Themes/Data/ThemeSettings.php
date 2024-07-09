<?php

declare(strict_types=1);

namespace Nova\Themes\Data;

use Illuminate\Contracts\Support\Arrayable;
use Nova\Settings\Data\FontFamilies;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class ThemeSettings extends Data implements Arrayable
{
    public function __construct(
        public FontFamilies $fonts,
        public array $settings = []
    ) {}

    public function hasSettings(): bool
    {
        return count($this->settings) > 0;
    }
}
