<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Features\Settings;

use Awcodes\Scribble\Enums\SlideDirection;
use Awcodes\Scribble\Livewire\ScribbleModal;
use Filament\Support\Enums\MaxWidth;
use Nova\Pages\Blocks\FormSchema;

abstract class FeatureBlockSettings extends ScribbleModal
{
    public static function getSlideDirection(): SlideDirection
    {
        return SlideDirection::Right;
    }

    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::ExtraLarge;
    }

    public function getFormFields(): array
    {
        return [
            ...FormSchema::heading(withOrientation: true),
            ...FormSchema::backgroundColor(),
        ];
    }
}
