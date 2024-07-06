<?php

declare(strict_types=1);

namespace Nova\Ranks\Data;

use Nova\Ranks\Enums\RankGroupStatus;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;

class RankGroupData extends Data
{
    public function __construct(
        public string $name,

        #[Enum(RankGroupStatus::class)]
        public ?RankGroupStatus $status,

        public ?string $base_image
    ) {}
}
