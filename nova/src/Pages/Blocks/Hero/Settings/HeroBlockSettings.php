<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero\Settings;

use Awcodes\Scribble\Enums\SlideDirection;
use Filament\Support\Enums\MaxWidth;
use Nova\Foundation\Scribble\ScribbleModal;

abstract class HeroBlockSettings extends ScribbleModal
{
    public static function getSlideDirection(): SlideDirection
    {
        return SlideDirection::Right;
    }

    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::ExtraLarge;
    }
}
