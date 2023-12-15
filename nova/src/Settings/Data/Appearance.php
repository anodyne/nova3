<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Nova\Foundation\Colors\Color;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class Appearance extends Data implements Arrayable
{
    public function __construct(
        public string $theme,
        #[MapInputName('icon_set')]
        public string $iconSet,
        #[MapInputName('avatar_shape')]
        public string $avatarShape,
        #[MapInputName('avatar_style')]
        public ?string $avatarStyle,
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
        #[MapInputName('font_provider')]
        public string $fontProvider,
        #[MapInputName('font_family')]
        public string $fontFamily,
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

    public function getAvatarStyles(): array
    {
        return [
            'adventurer' => 'Adventurer',
            'adventurer-neutral' => 'Adventurer Neutral',
            'avataaars' => 'Avataaars',
            'avataaars-neutral' => 'Avataaars Neutral',
            'big-ears' => 'Big Ears',
            'big-ears-neutral' => 'Big Ears Neutral',
            'big-smile' => 'Big Smile',
            'bottts' => 'Bottts',
            'bottts-neutral' => 'Bottts Neutral',
            'croodles' => 'Croodles',
            'croodles-neutral' => 'Croodles Neutral',
            'fun-emoji' => 'Fun Emoji',
            'icons' => 'Icons',
            'identicon' => 'Identicon',
            'initials' => 'Initials',
            'lorelei' => 'Lorelei',
            'lorelei-neutral' => 'Lorelei Neutral',
            'micah' => 'Micah',
            'miniavs' => 'Miniavs',
            'notionists' => 'Notionists',
            'notionists-neutral' => 'Notionists Neutral',
            'open-peeps' => 'Open Peeps',
            'personas' => 'Personas',
            'pixel-art' => 'Pixel Art',
            'pixel-art-neutral' => 'Pixel Art Neutral',
            'rings' => 'Rings',
            'shapes' => 'Shapes',
            'thumbs' => 'Thumbs',
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
