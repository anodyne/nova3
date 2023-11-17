<?php

declare(strict_types=1);

namespace Nova\Foundation\Enums;

use Filament\Support\Contracts\HasLabel;

enum NotificationAudience: string implements HasLabel
{
    case admin = 'admin';

    case group = 'group';

    case personal = 'personal';

    public function bgColor(): string
    {
        return match ($this) {
            self::admin => 'bg-info-500',
            self::group => 'bg-primary-500',
            self::personal => 'bg-success-500',
        };
    }

    public function canUseDiscord(): bool
    {
        return match ($this) {
            self::personal => false,
            default => true,
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::admin => 'info',
            self::group => 'primary',
            self::personal => 'success',
        };
    }

    public function description(): ?string
    {
        return match ($this) {
            self::admin => 'Admin notifications are automated messages sent to various game admins. These cannot be configured individually.',
            self::group => 'Group notifications are messages sent out to all active members of the game.',
            self::personal => 'Personal notifications are messages sent out to individual players.',
            default => null,
        };
    }

    public function getLabel(): ?string
    {
        return ucfirst($this->value);
    }
}
