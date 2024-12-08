<?php

declare(strict_types=1);

namespace Nova\Addons\Data;

use Nova\Addons\Enums\AddonStatus;
use Nova\Addons\Enums\AddonType;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;

class AddonData extends Data
{
    public function __construct(
        public string $name,

        public string $location,

        public string $version,

        public ?string $credits,

        #[Enum(AddonType::class)]
        public AddonType $type,

        #[Enum(AddonStatus::class)]
        public AddonStatus $status,

        public ?string $preview,

        public ?AddonSettings $settings,

        public ?AddonRepository $repository
    ) {}
}
