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

    public function color(): string
    {
        return match ($this) {
            self::admin => 'info',
            self::group => 'primary',
            self::personal => 'success',
        };
    }

    public function getLabel(): ?string
    {
        return ucfirst($this->value);
    }
}
