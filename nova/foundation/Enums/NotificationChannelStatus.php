<?php

declare(strict_types=1);

namespace Nova\Foundation\Enums;

enum NotificationChannelStatus: string
{
    case enabled = 'enabled';

    case enabledLocked = 'enabled-locked';

    case disabled = 'disabled';

    case disabledLocked = 'disabled-locked';

    public function icon(): string
    {
        return match ($this) {
            self::enabled => iconName('check'),
            self::enabledLocked => iconName('lock-check'),
            self::disabled => iconName('x'),
            self::disabledLocked => iconName('lock-x'),
            default => null,
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::enabled => 'success',
            self::enabledLocked => 'success',
            self::disabled => 'gray',
            self::disabledLocked => 'danger',
            default => 'gray',
        };
    }
}
