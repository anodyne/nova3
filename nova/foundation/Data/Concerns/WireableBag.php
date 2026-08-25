<?php

declare(strict_types=1);

namespace Nova\Foundation\Data\Concerns;

trait WireableBag
{
    /** @return array<string, mixed> */
    public function toLivewire(): array
    {
        return $this->toArray();
    }

    public static function fromLivewire(mixed $value): static
    {
        return static::from($value);
    }
}
