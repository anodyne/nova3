<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Nova\Settings\Enums\PostingTarget;
use Nova\Settings\Enums\PostingTimeframe;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;

class PostingActivity extends Data implements Arrayable
{
    public function __construct(
        #[Enum(PostingTarget::class)]
        public PostingTarget $target,

        public int $requirement,

        #[Enum(PostingTimeframe::class)]
        public PostingTimeframe $timeframe,

        public ?int $rollingDays
    ) {}
}
