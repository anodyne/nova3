<?php

declare(strict_types=1);

namespace Nova\Setup;

use Illuminate\Support\Arr;

class Randomize
{
    public static function avatarShape(): string
    {
        return Arr::random(['circle', 'square']);
    }

    public static function avatarStyle(): string
    {
        return Arr::random([
            'adventurer',
            'adventurer-neutral',
            'avataaars',
            'avataaars-neutral',
            'big-ears',
            'big-ears-neutral',
            'big-smile',
            'bottts',
            'bottts-neutral',
            'croodles',
            'croodles-neutral',
            'fun-emoji',
            'icons',
            'identicon',
            'initials',
            'lorelei',
            'lorelei-neutral',
            'micah',
            'miniavs',
            'notionists',
            'notionists-neutral',
            'open-peeps',
            'personas',
            'pixel-art',
            'pixel-art-neutral',
            'rings',
            'shapes',
            'thumbs',
        ]);
    }

    public static function publicBodyFont(): string
    {
        return Arr::random([
            'Geist',
            'Inter',
            'Nacelle',
            'Onest',
            'Public Sans',
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
