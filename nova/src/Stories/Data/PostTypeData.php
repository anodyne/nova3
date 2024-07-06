<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Nova\Stories\Enums\PostTypeStatus;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Data;

class PostTypeData extends Data
{
    public function __construct(
        public string $name,

        public string $key,

        public ?string $description,

        #[Enum(PostTypeStatus::class)]
        public ?PostTypeStatus $status,

        public Fields $fields,

        public Options $options,

        public ?int $role_id,

        #[In('in-character', 'out-of-character')]
        public string $visibility,

        public ?string $icon,

        public ?string $color,
    ) {}
}
