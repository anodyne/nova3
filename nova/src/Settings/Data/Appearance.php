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
    ) {}

    public static function fromArray(array $data = []): self
    {
        return new self(
            theme: data_get($data, 'theme'),
            avatarShape: AvatarShape::tryFrom(data_get($data, 'avatar_shape', 'none')),
            avatarStyle: AvatarStyle::tryFrom(data_get($data, 'avatar_style', 'bottts')),
            imagePath: data_get($data, 'image_path'),
            colorsGray: data_get($data, 'colors_gray', 'Gray'),
            colorsPrimary: data_get($data, 'colors_primary', 'Sky'),
            colorsDanger: data_get($data, 'colors_danger', 'Rose'),
            colorsWarning: data_get($data, 'colors_warning', 'Amber'),
            colorsSuccess: data_get($data, 'colors_success', 'Emerald'),
            colorsInfo: data_get($data, 'colors_info', 'Purple'),
            adminFonts: FontFamilies::from(data_get($data, 'adminFonts', [])),
            panda: data_get($data, 'panda', false)
        );
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
