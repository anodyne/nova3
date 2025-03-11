<?php

declare(strict_types=1);

namespace Nova\Foundation\Data\Concerns;

trait WireableBag
{
    public function toLivewire(): array
    {
        return $this->toArray();
    }

    public static function fromLivewire($value): static
    {
        return static::from($value);
    }
}
