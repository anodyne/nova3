<?php

declare(strict_types=1);

namespace Nova\Foundation\Concerns;

trait HasSelectOptions
{
    public static function toOptions(): array
    {
        return collect(static::cases())
            ->flatMap(fn ($case) => [$case->value => $case->getLabel()])
            ->all();
    }
}
