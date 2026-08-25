<?php

declare(strict_types=1);

namespace Nova\Foundation\Colors;

use Filament\Support\Colors\Color as FilamentColor;

class Color extends FilamentColor
{
    /** @return array<int, string> */
    public static function additionalShades(string $color): array
    {
        $shades = [
            'Red' => [25 => 'oklch(0.988 0.003 17.212)'],
            'Orange' => [25 => 'oklch(0.993 0.005 72.944)'],
            'Amber' => [25 => 'oklch(1.000 0.003 95.107)'],
            'Yellow' => [25 => 'oklch(0.994 0.003 101.721)'],
            'Lime' => [25 => 'oklch(0.996 0.013 119.971)'],
            'Green' => [25 => 'oklch(0.992 0.005 155.367)'],
            'Emerald' => [25 => 'oklch(0.994 0.006 167.644)'],
            'Teal' => [25 => 'oklch(1.000 0.000 180.679)'],
            'Cyan' => [25 => 'oklch(0.998 0.006 199.615)'],
            'Sky' => [25 => 'oklch(0.990 0.006 236.518)'],
            'Blue' => [25 => 'oklch(0.989 0.005 254.114)'],
            'Indigo' => [25 => 'oklch(0.978 0.010 272.077)'],
            'Violet' => [25 => 'oklch(0.982 0.009 293.340)'],
            'Purple' => [25 => 'oklch(0.992 0.004 308.861)'],
            'Fuchsia' => [25 => 'oklch(0.990 0.007 320.661)'],
            'Pink' => [25 => 'oklch(0.982 0.007 343.668)'],
            'Rose' => [25 => 'oklch(0.983 0.007 12.343)'],
            'Slate' => [25 => 'oklch(0.9920 0.0010 247.839)'],
            'Gray' => [25 => 'oklch(0.9940 0.0015 239.488)'],
            'Zinc' => [25 => 'oklch(0.9940 0.0000 36.812)'],
            'Neutral' => [25 => 'oklch(0.9925 0.0000 0.000)'],
            'Stone' => [25 => 'oklch(0.9925 0.0010 106.423)'],
        ];

        return data_get($shades, $color, []);
    }
}
