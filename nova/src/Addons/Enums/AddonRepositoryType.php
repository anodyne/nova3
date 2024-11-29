<?php

declare(strict_types=1);

namespace Nova\Addons\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum AddonRepositoryType: string implements HasColor, HasLabel
{
    use HasSelectOptions;

    case Anodyne = 'anodyne';

    case Github = 'github';

    public function bgColor(): string
    {
        return match ($this) {
            self::Anodyne => 'bg-primary-500',
            self::Github => 'bg-info-500',
            default => 'bg-gray-500',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Anodyne => 'primary',
            self::Github => 'info',
            default => 'gray',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Anodyne => 'Nova Add-on Exchange',
            self::Github => 'Github',
            default => 'None',
        };
    }
}
