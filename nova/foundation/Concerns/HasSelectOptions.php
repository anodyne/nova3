<?php

declare(strict_types=1);

namespace Nova\Foundation\Concerns;

trait HasSelectOptions
{
    /** @return array<string, string> */
    public static function toOptions(): array
    {
        return collect(static::cases())
            ->flatMap(fn ($case): array => [$case->value => $case->getLabel()])
            ->all();
    }
}
