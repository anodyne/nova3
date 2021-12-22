<?php

declare(strict_types=1);

namespace Nova\Ranks\Data;

use Spatie\LaravelData\Data;

class RankItemData extends Data
{
    public function __construct(
        public string $base_image,
        public ?string $overlay_image,
        public ?int $group_id,
        public ?int $name_id,
    ) {
    }
}
