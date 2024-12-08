<?php

declare(strict_types=1);

namespace Nova\Foundation\Enums;

use Filament\Support\Contracts\HasLabel;

enum NotificationAudience: string implements HasLabel
{
    case Admin = 'admin';

    case Group = 'group';

    case Personal = 'personal';

    public function bgColor(): string
    {
        return match ($this) {
            self::Admin => 'bg-info-500',
            self::Group => 'bg-primary-500',
            self::Personal => 'bg-success-500',
        };
    }

    public function canUseDiscord(): bool
    {
        return match ($this) {
            self::Personal => false,
            default => true,
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Admin => 'info',
            self::Group => 'primary',
            self::Personal => 'success',
        };
    }

    public function description(): ?string
    {
        return match ($this) {
            self::Admin => 'Admin notifications are automated messages sent to various game admins. These cannot be configured individually.',
            self::Group => 'Group notifications are messages sent out to all active members of the game.',
            self::Personal => 'Personal notifications are messages sent out to individual players.',
            default => null,
        };
    }

    public function getLabel(): ?string
    {
        return ucfirst($this->value);
    }
}
