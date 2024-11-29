<?php

declare(strict_types=1);

namespace Nova\Addons\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Addons\Enums\AddonStatus;
use Nova\Addons\Enums\AddonType;

class AddonBuilder extends Builder
{
    public function active(): self
    {
        return $this->where('status', AddonStatus::Active);
    }

    public function extension(): self
    {
        return $this->where('type', AddonType::Extension);
    }

    public function genre(): self
    {
        return $this->where('type', AddonType::Genre);
    }

    public function inactive(): self
    {
        return $this->where('status', AddonStatus::Inactive);
    }

    public function location($location): self
    {
        return $this->where('location', $location);
    }

    public function rankSet(): self
    {
        return $this->where('type', AddonType::Rank);
    }
}
