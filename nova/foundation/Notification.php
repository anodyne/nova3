<?php

declare(strict_types=1);

namespace Nova\Foundation;

use Filament\Notifications\Notification as BaseNotification;
use Nova\Foundation\Icons\Icon;

class Notification extends BaseNotification
{
    public function success(): static
    {
        $this->icon($this->getIconName('check'));
        $this->iconColor('success');

        return $this;
    }

    public function warning(): static
    {
        $this->icon($this->getIconName('warning'));
        $this->iconColor('warning');

        return $this;
    }

    public function danger(): static
    {
        $this->icon($this->getIconName('alert'));
        $this->iconColor('danger');

        return $this;
    }

    protected function getIconName(string $icon): string
    {
        return app(Icon::class)->make($icon)->name();
    }
}
