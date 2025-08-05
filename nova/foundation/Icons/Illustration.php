<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum Illustration: string implements HasLabel
{
    case EmptyMessages = 'empty-messages';

    public function getLabel(): string|Htmlable|null
    {
        return str($this->name)
            ->headline()
            ->toString();
    }
}
