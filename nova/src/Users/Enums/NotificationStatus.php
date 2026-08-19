<?php

declare(strict_types=1);

namespace Nova\Users\Enums;

use Filament\Support\Contracts\HasLabel;

enum NotificationStatus: string implements HasLabel
{
    case All = 'all';
    case Unread = 'unread';

    public function getLabel(): string
    {
        return ucfirst($this->value);
    }
}
