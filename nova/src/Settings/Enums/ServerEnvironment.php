<?php

declare(strict_types=1);

namespace Nova\Settings\Enums;

use Filament\Support\Contracts\HasLabel;

enum ServerEnvironment: string implements HasLabel
{
    case Local = 'local';
    case Production = 'production';

    public function getLabel(): string
    {
        return ucfirst($this->value);
    }
}
