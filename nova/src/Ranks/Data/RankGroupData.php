<?php

declare(strict_types=1);

namespace Nova\Ranks\Data;

use Nova\Ranks\Enums\RankGroupStatus;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class RankGroupData extends Data
{
    public function __construct(
        #[Required, StringType()]
        public string $name,

        #[Nullable, Enum(RankGroupStatus::class)]
        public RankGroupStatus $status,

        #[Nullable, StringType()]
        public ?string $base_image
    ) {
    }
}
