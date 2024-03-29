<?php

declare(strict_types=1);

namespace Nova\Foundation\Colors;

use Filament\Support\Colors\Color as FilamentColor;

class Color extends FilamentColor
{
    public const SeaGreen = [
        50 => '240, 255, 244',
        100 => '230, 251, 237',
        200 => '204, 242, 217',
        300 => '154, 230, 180',
        400 => '104, 211, 145',
        500 => '72, 187, 120',
        600 => '56, 161, 105',
        700 => '41, 107, 75',
        800 => '35, 86, 62',
        900 => '29, 71, 52',
        950 => '14, 56, 37',
    ];

    public const Orchid = [
        50 => '252, 245, 255',
        100 => '247, 232, 255',
        200 => '239, 211, 255',
        300 => '228, 176, 253',
        400 => '212, 127, 251',
        500 => '193, 78, 243',
        600 => '170, 45, 223',
        700 => '144, 31, 191',
        800 => '121, 29, 156',
        900 => '100, 27, 126',
        950 => '79, 6, 105',
    ];

    public const RadicalRed = [
        50 => '254, 240, 241',
        100 => '253, 226, 228',
        200 => '253, 204, 210',
        300 => '252, 164, 174',
        400 => '249, 112, 132',
        500 => '242, 63, 93',
        600 => '223, 29, 72',
        700 => '188, 18, 60',
        800 => '156, 18, 56',
        900 => '135, 19, 55',
        950 => '119, 3, 39',
    ];

    public const ImperialRed = [
        50 => '255, 245, 245',
        100 => '254, 227, 227',
        200 => '254, 215, 215',
        300 => '254, 178, 178',
        400 => '252, 129, 129',
        500 => '245, 101, 101',
        600 => '229, 62, 62',
        700 => '197, 48, 48',
        800 => '155, 44, 44',
        900 => '130, 39, 39',
        950 => '112, 21, 21',
    ];
}
