<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Notifications;

use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Support\Traits\Conditionable;

class Notification extends FilamentNotification
{
    use Conditionable;
}
