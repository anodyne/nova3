<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Filament\Support\Color;
use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class Appearance extends Data implements Arrayable
{
    public function __construct(
        public string $theme,
        #[MapInputName('icon-set')]
        public string $iconSet,
        #[MapInputName('image_path')]
        public ?string $imagePath,
        #[MapInputName('colors_gray')]
        public string $colorsGray,
        #[MapInputName('colors_primary')]
        public string $colorsPrimary,
        #[MapInputName('colors_danger')]
        public string $colorsDanger,
        #[MapInputName('colors_warning')]
        public string $colorsWarning,
        #[MapInputName('colors_success')]
        public string $colorsSuccess,
        #[MapInputName('colors_info')]
        public string $colorsInfo,
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

        return constant('Filament\Support\Color::'.$color);
    }
}
