<?php

declare(strict_types=1);

namespace Nova\Users\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum NotificationStatus: string implements HasLabel
{
    case Unread = 'unread';

    case All = 'all';

    public function getLabel(): string|Htmlable|null
    {
        return ucfirst($this->value);
    }
}
