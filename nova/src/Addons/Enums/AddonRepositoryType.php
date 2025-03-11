<?php

declare(strict_types=1);

namespace Nova\Addons\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AddonRepositoryType: string implements HasColor, HasLabel
{
    case Anodyne = 'anodyne';

    case Github = 'github';

    public function bgColor(): string
    {
        return match ($this) {
            self::Anodyne => 'bg-primary-500',
            self::Github => 'bg-info-500',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Anodyne => 'primary',
            self::Github => 'info',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Anodyne => 'Nova Add-on Exchange',
            self::Github => 'Github',
        };
    }
}
