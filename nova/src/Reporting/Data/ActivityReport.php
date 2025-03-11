<?php

declare(strict_types=1);

namespace Nova\Reporting\Data;

use Bag\Bag;
use Illuminate\Support\Collection;
use Livewire\Wireable;
use Nova\Foundation\Data\Concerns\WireableBag;

/**
 * @method static static from(int $active, int $total, ?Collection $results)
 */
readonly class ActivityReport extends Bag implements Wireable
{
    use WireableBag;

    public function __construct(
        public int $active,
        public int $total,
        public ?Collection $results
    ) {}

    public function percentage(): int
    {
        if ($this->total === 0) {
            return 0;
        }

        $percentage = round(($this->active / $this->total) * 100, 0);

        return $percentage > 100 ? 100 : (int) $percentage;
    }
}
