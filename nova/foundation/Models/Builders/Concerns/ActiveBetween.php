<?php

declare(strict_types=1);

namespace Nova\Foundation\Models\Builders\Concerns;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;

trait ActiveBetween
{
    public function activeBetween(CarbonInterface $start, CarbonInterface $end): self
    {
        return $this->whereHas('statusHistories', function (Builder $query) use ($start, $end): void {
            $query->where('started_at', '<=', $end->endOfDay())
                ->where(function (Builder $query) use ($start): void {
                    $query->whereNull('ended_at')
                        ->orWhere('ended_at', '>=', $start->copy()->endOfDay());
                });
        });
    }
}
