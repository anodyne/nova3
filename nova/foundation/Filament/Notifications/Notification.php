<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Notifications;

use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Support\Traits\Conditionable;

class Notification extends FilamentNotification
{
    use Conditionable;

    public function danger(): static
    {
        parent::danger();

        $this->icon(iconName('alert'));

        return $this;
    }

    public function info(): static
    {
        parent::info();

        $this->icon(iconName('info'));

        return $this;
    }

    public function success(): static
    {
        parent::success();

        $this->icon(iconName('check'));

        return $this;
    }

    public function warning(): static
    {
        parent::warning();

        $this->icon(iconName('alert'));

        return $this;
    }
}
