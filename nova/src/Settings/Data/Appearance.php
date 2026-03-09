<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Bag\Attributes\MapInputName;
use Bag\Attributes\Transforms;
use Bag\Bag;
use Bag\Mappers\SnakeCase;
use Illuminate\Http\Request;
use Nova\Foundation\Colors\Color;
use Nova\Settings\Enums\AvatarShape;
use Nova\Settings\Enums\AvatarStyle;

/**
 * @method static static from(string $theme, AvatarShape $avatarShape, AvatarStyle $avatarStyle, string $colorsGray, string $colorsPrimary, string $colorsDanger, string $colorsWarning, string $colorsSuccess, string $colorsInfo, FontFamilies $adminFonts)
 */
#[MapInputName(SnakeCase::class)]
readonly class Appearance extends Bag
{
    public function __construct(
        public string $theme,
        public AvatarShape $avatarShape,
        public AvatarStyle $avatarStyle,
        public string $colorsGray,
        public string $colorsPrimary,
        public string $colorsDanger,
        public string $colorsWarning,
        public string $colorsSuccess,
        public string $colorsInfo,
        public FontFamilies $adminFonts
    ) {}

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

    public function getColorFromSemanticColor(string $semanticColor): string
    {
        $semanticColor = ucfirst($semanticColor);

        $property = "colors{$semanticColor}";

        return strtolower($this->{$property});
    }

    protected function processColor(string $color): array
    {
        if (is_string($color) && str_starts_with($color, '#')) {
            return Color::generateV3Palette($color);
        }

        if (is_string($color) && str_starts_with($color, 'rgb')) {
            return Color::generateV3Palette($color);
        }

        return collect(constant('Nova\Foundation\Colors\Color::'.$color))
            ->union(Color::additionalShades($color))
            ->all();
    }

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'theme' => $request->input('theme'),
            'avatarShape' => AvatarShape::tryFrom($request->input('avatar_shape')) ?? AvatarShape::Square,
            'avatarStyle' => AvatarStyle::tryFrom($request->input('avatar_style')) ?? AvatarStyle::BigEarsNeutral,
            'colorsGray' => $request->input('colors_gray'),
            'colorsPrimary' => $request->input('colors_primary'),
            'colorsDanger' => $request->input('colors_danger'),
            'colorsWarning' => $request->input('colors_warning'),
            'colorsSuccess' => $request->input('colors_success'),
            'colorsInfo' => $request->input('colors_info'),
            'adminFonts' => FontFamilies::from($request),
        ];
    }
}
