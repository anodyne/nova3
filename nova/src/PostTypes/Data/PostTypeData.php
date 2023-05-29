<?php

declare(strict_types=1);

namespace Nova\PostTypes\Data;

use Nova\PostTypes\Enums\PostTypeStatus;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Data;

class PostTypeData extends Data
{
    public function __construct(
        public string $name,
        public string $key,
        public ?string $description,
        public ?PostTypeStatus $status,
        public Fields $fields,
        public Options $options,
        public ?int $role_id,
        public string $visibility,
        public ?string $icon,
        public ?string $color,
    ) {
    }

    public static function rules(): array
    {
        return [
            'status' => [new Enum(PostTypeStatus::class)],
            'visibility' => [new In('in-character', 'out-of-character')],
        ];
    }
}
