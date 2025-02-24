<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire\Concerns;

trait ModalBehaviors
{
    public static function behavior(): array
    {
        return [
            // Close the slide-over if the escape key is pressed
            'close-on-escape' => static::closeOnEscape(),

            // Close the slide-over if someone clicks outside the slide-over
            'close-on-backdrop-click' => static::closeOnBackdropClick(),

            // Trap the users focus inside the slide-over (e.g. input autofocus and going back and forth between input fields)
            'trap-focus' => static::trapFocus(),

            // Remove all unsaved changes once someone closes the slide-over
            'remove-state-on-close' => static::removeStateOnClose(),
        ];
    }

    public static function closeOnEscape(): bool
    {
        return true;
    }

    public static function closeOnBackdropClick(): bool
    {
        return true;
    }

    public static function trapFocus(): bool
    {
        return true;
    }

    public static function removeStateOnClose(): bool
    {
        return false;
    }
}
