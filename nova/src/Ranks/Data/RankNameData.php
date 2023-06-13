<?php

declare(strict_types=1);

namespace Nova\Ranks\Data;

use Nova\Ranks\Enums\RankNameStatus;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;

class RankNameData extends Data
{
    public function __construct(
        public string $name,
        public ?RankNameStatus $status
    ) {
    }

    public static function rules(): array
    {
        return [
            'status' => [new Enum(RankNameStatus::class)],
        ];
    }
}
