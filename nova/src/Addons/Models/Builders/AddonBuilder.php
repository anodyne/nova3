<?php

declare(strict_types=1);

namespace Nova\Addons\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Addons\Enums\AddonType;
use Nova\Foundation\Models\Builders\Concerns\QueriesStatus;

class AddonBuilder extends Builder
{
    use QueriesStatus;

    public function extension(): self
    {
        return $this->where('type', AddonType::Extension);
    }

    public function genre(): self
    {
        return $this->where('type', AddonType::Genre);
    }

    public function location(string $location): self
    {
        return $this->where('location', $location);
    }

    public function rankSet(): self
    {
        return $this->where('type', AddonType::Rank);
    }

    public function searchFor($columns, $search): self
    {
        return $this->whereFullText($columns, $search.'*', ['mode' => 'boolean']);
    }
}
