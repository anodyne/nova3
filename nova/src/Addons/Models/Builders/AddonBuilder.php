<?php

declare(strict_types=1);

namespace Nova\Addons\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Addons\Enums\AddonType;
use Nova\Addons\Models\Addon;
use Nova\Foundation\Models\Builders\Concerns\QueriesStatus;

/**
 * @template TModel of Addon
 *
 * @extends Builder<TModel>
 */
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

    public function searchFor($column, $search): self
    {
        return $this->where(function ($query) use ($column, $search): void {
            $query->whereFullText($column, $search)
                ->orWhereLike($column, "%{$search}%");
        });
    }
}
