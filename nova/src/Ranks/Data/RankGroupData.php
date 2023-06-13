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
        public ?RankGroupStatus $status,
        public ?string $base_image
    ) {
    }

    public static function rules(): array
    {
        return [
            'status' => [new Enum(RankGroupStatus::class)],
        ];
    }
}
