<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Nova\Foundation\ColorScales;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class Appearance extends Data implements Arrayable
{
    public function __construct(
        public string $theme = 'pulsar',

        #[MapInputName('icon-set')]
        public string $iconSet = 'fluent',

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

    public function getColorShades($type)
    {
        $variable = str($type)->ucfirst()->prepend('colors');
        $color = $this->$variable;

        return match ($color) {
            default => ColorScales\Gray::class,
            'amber' => ColorScales\Amber::class,
            'blue' => ColorScales\Blue::class,
            'blue-dark' => ColorScales\BlueDark::class,
            'blue-light' => ColorScales\BlueLight::class,
            'cyan' => ColorScales\Cyan::class,
            'emerald' => ColorScales\Emerald::class,
            'fuchsia' => ColorScales\Fuchsia::class,
            'gray-blue' => ColorScales\GrayBlue::class,
            'gray-cool' => ColorScales\GrayCool::class,
            'gray-iron' => ColorScales\GrayIron::class,
            'gray-modern' => ColorScales\GrayModern::class,
            'gray-neutral' => ColorScales\GrayNeutral::class,
            'gray-true' => ColorScales\GrayTrue::class,
            'gray-warm' => ColorScales\GrayWarm::class,
            'green' => ColorScales\Green::class,
            'green-light' => ColorScales\GreenLight::class,
            'green-monster' => ColorScales\GreenMonster::class,
            'indigo' => ColorScales\Indigo::class,
            'lilac' => ColorScales\Lilac::class,
            'moss' => ColorScales\Moss::class,
            'orange' => ColorScales\Orange::class,
            'international-orange' => ColorScales\InternationalOrange::class,
            'pink' => ColorScales\Pink::class,
            'purple' => ColorScales\Purple::class,
            'red' => ColorScales\Red::class,
            'rose' => ColorScales\Rose::class,
            'teal' => ColorScales\Teal::class,
            'violet' => ColorScales\Violet::class,
            'yellow' => ColorScales\Yellow::class,
        };
    }
}
