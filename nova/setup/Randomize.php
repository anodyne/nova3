<?php

declare(strict_types=1);

namespace Nova\Setup;

use Illuminate\Support\Arr;
use Nova\Settings\Enums\AvatarShape;
use Nova\Settings\Enums\AvatarStyle;

class Randomize
{
    public static function avatarShape(): AvatarShape
    {
        return Arr::random(AvatarShape::cases());
    }

    public static function avatarStyle(): AvatarStyle
    {
        return Arr::random(AvatarStyle::cases());
    }

    public static function publicBodyFont(): string
    {
        return Arr::random([
            'Geist',
            'Inter',
            'Nacelle',
            'Onest',
            'Public Sans',
            'Sn Pro',
        ]);
    }

    public static function publicHeaderFont(): string
    {
        return Arr::random([
            'Aileron',
            'Figtree',
            'Geist',
            'Inter',
            'Jakarta',
            'Nacelle',
            'Onest',
            'Outfit',
            'Public Sans',
            'Satoshi',
            'Space Grotesk',
            'Sn Pro',
            'Supreme',
            'Thicccboi',
        ]);
    }

    public static function theme(): string
    {
        return Arr::random([
            'Pulsar',
            'Titan',
            'EventHorizon',
            // 'Cerritos',
            // 'Celestial',
        ]);
    }
}
