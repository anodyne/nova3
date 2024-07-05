<?php

declare(strict_types=1);

namespace Nova\Forms\Enums;

use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum FormType: string implements HasLabel
{
    use HasSelectOptions;

    case Advanced = 'advanced';

    case Basic = 'basic';

    public function bgColor(): string
    {
        return match ($this) {
            self::Advanced => 'bg-primary-500',
            self::Basic => 'bg-info-500',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Advanced => 'primary',
            self::Basic => 'info',
        };
    }

    public function getLabel(): ?string
    {
        return ucfirst($this->value);
    }
}
