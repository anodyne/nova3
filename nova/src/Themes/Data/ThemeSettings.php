<?php

declare(strict_types=1);

namespace Nova\Themes\Data;

use Bag\Attributes\MapInputName;
use Bag\Bag;
use Bag\Mappers\SnakeCase;
use Nova\Settings\Data\FontFamilies;

/**
 * @method static static from(FontFamilies $fonts, array $settings)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
#[MapInputName(SnakeCase::class)]
readonly class ThemeSettings extends Bag
{
    public function __construct(
        public FontFamilies $fonts,
        public array $settings = []
    ) {}

    public function hasSettings(): bool
    {
        return count($this->settings) > 0;
    }

    public function accentColor(): ?string
    {
        return data_get($this->settings, 'accentColor', '#406ceb');
    }

    public function textAccentColor(): ?string
    {
        return data_get($this->settings, 'textAccentColor', '#000');
    }
}
