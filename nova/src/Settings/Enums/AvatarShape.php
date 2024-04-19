<?php

declare(strict_types=1);

namespace Nova\Settings\Enums;

use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum AvatarShape: string implements HasLabel
{
    use HasSelectOptions;

    case Circle = 'circle';

    case Square = 'square';

    case None = 'none';

    public function getLabel(): ?string
    {
        return ucfirst($this->value);
    }
}
