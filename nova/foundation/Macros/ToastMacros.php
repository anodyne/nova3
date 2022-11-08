<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Nova\Foundation\Notification;

class ToastMacros
{
    public function withToast()
    {
        return function ($title, $message = null) {
            Notification::make()
                ->title($title)
                ->body($message)
                ->success()
                ->send();

            return $this;
        };
    }

    public function withErrorToast()
    {
        return function ($title, $message = null) {
            Notification::make()
                ->title($title)
                ->body($message)
                ->danger()
                ->send();

            return $this;
        };
    }
}
