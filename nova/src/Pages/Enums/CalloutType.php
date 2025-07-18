<?php

declare(strict_types=1);

namespace Nova\Pages\Enums;

use Filament\Support\Contracts\HasLabel;

enum CalloutType: string implements HasLabel
{
    case Text = 'text';

    case Badge = 'badge';

    public function getLabel(): ?string
    {
        return ucfirst($this->value);
    }
}
