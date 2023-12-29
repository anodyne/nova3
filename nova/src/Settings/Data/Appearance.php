<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Nova\Foundation\Colors\Color;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class Appearance extends Data implements Arrayable
{
    public function __construct(
        public string $theme,
        public string $iconSet,
        public string $avatarShape,
        public ?string $avatarStyle,
        public ?string $imagePath,
        public string $colorsGray,
        public string $colorsPrimary,
        public string $colorsDanger,
        public string $colorsWarning,
        public string $colorsSuccess,
        public string $colorsInfo,
        public string $fontProvider,
        public string $fontFamily,
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
