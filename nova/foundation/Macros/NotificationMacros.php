<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Nova\Foundation\Filament\Notifications\Notification;

class NotificationMacros
{
    public function notify()
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

    public function notifyOfError()
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

    public function notifyOfWarning()
    {
        return function ($title, $message = null) {
            Notification::make()
                ->title($title)
                ->body($message)
                ->warning()
                ->send();

            return $this;
        };
    }
}
