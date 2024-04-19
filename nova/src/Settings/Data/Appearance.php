<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Nova\Foundation\Colors\Color;
use Nova\Settings\Enums\AvatarShape;
use Nova\Settings\Enums\AvatarStyle;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class Appearance extends Data
{
    public function __construct(
        public string $theme,
        public AvatarShape $avatarShape,
        public ?AvatarStyle $avatarStyle,
        public ?string $imagePath,
        public string $colorsGray,
        public string $colorsPrimary,
        public string $colorsDanger,
        public string $colorsWarning,
        public string $colorsSuccess,
        public string $colorsInfo,
        public FontFamilies $adminFonts,
        public bool $panda,
    ) {
    }

    public function getColors(): array
    {
        return [
            'primary' => $this->processColor($this->colorsPrimary),
            'gray' => $this->processColor($this->colorsGray),
            'danger' => $this->processColor($this->colorsDanger),
            'warning' => $this->processColor($this->colorsWarning),
            'success' => $this->processColor($this->colorsSuccess),
            'info' => $this->processColor($this->colorsInfo),
        ];
    }

    protected function processColor(string $color): array
    {
        if (is_string($color) && str_starts_with($color, '#')) {
            return Color::hex($color);
        }

        if (is_string($color) && str_starts_with($color, 'rgb')) {
            return Color::rgb($color);
        }

        return constant('Nova\Foundation\Colors\Color::'.$color);
    }
}
