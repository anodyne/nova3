<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Nova\Foundation\Enums\BasicStatus;
use Nova\Stories\Enums\PostTypeVisibility;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;

class PostTypeData extends Data
{
    public function __construct(
        public string $name,

        public string $key,

        public ?string $description,

        #[Enum(BasicStatus::class)]
        public ?BasicStatus $status,

        public Fields $fields,

        public Options $options,

        public ?int $role_id,

        #[Enum(PostTypeVisibility::class)]
        public PostTypeVisibility $visibility,

        public ?string $icon,

        public ?string $color,
    ) {}
}
