<?php

declare(strict_types=1);

namespace Nova\Pages\Enums;

use Filament\Support\Contracts\HasLabel;

enum PageVerb: string implements HasLabel
{
    case get = 'get';
    case post = 'post';
    case put = 'put';
    case delete = 'delete';

    public function color(): string
    {
        return match ($this) {
            self::get => 'primary',
            self::post => 'warning',
            self::put => 'info',
            self::delete => 'danger',
        };
    }

    public function getLabel(): ?string
    {
        return strtoupper($this->value);
    }

    public static function toOptions(): array
    {
        return collect(self::cases())
            ->flatMap(fn ($case) => [$case->value => $case->getLabel()])
            ->all();
    }
}
