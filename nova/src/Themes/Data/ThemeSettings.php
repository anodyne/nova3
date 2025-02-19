<?php

declare(strict_types=1);

namespace Nova\Themes\Data;

use Bag\Attributes\MapInputName;
use Bag\Bag;
use Bag\Mappers\SnakeCase;
use Nova\Settings\Data\FontFamilies;
use Spatie\Color\Contrast;
use Spatie\Color\Hex;

/**
 * @method static static from(FontFamilies $fonts, array $settings)
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
        $fallbackTextColor = (Contrast::ratio(Hex::fromString($this->accentColor()), Hex::fromString('#fff')) >= 2.0)
            ? '#fff'
            : '#000';

        return data_get($this->settings, 'textAccentColor', $fallbackTextColor);
    }
}
