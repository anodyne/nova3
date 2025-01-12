<?php

declare(strict_types=1);

namespace Nova\Reporting\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Data;

class PostTypeReport extends Data implements Arrayable
{
    public function __construct(
        public ?Collection $results
    ) {}
}
