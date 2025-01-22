<?php

declare(strict_types=1);

namespace Nova\Foundation\Models\Builders\Concerns;

use Nova\Foundation\Enums\BasicStatus;

trait QueriesStatus
{
    public function active(): self
    {
        return $this->where('status', BasicStatus::Active);
    }

    public function inactive(): self
    {
        return $this->where('status', BasicStatus::Inactive);
    }
}
