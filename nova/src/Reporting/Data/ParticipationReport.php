<?php

declare(strict_types=1);

namespace Nova\Reporting\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class ParticipationReport extends Data implements Arrayable, Wireable
{
    use WireableData;

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
