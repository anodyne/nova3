<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Closure;
use Nova\Foundation\Filament\Notifications\Notification;

class NotificationMacros
{
    public function notify()
    {
        return function (string|Closure|null $title, string|Closure|null $message = null): static {
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
        return function (string|Closure|null $title, string|Closure|null $message = null): static {
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
        return function (string|Closure|null $title, string|Closure|null $message = null): static {
            Notification::make()
                ->title($title)
                ->body($message)
                ->warning()
                ->send();

            return $this;
        };
    }
}
