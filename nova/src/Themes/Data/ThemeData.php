<?php

declare(strict_types=1);

namespace Nova\Themes\Data;

use Nova\Addons\Data\AddonRepository;
use Nova\Foundation\Enums\BasicStatus;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;

class ThemeData extends Data
{
    public function __construct(
        public string $name,

        public ?string $location,

        public ?string $version,

        public ?string $credits,

        #[Enum(BasicStatus::class)]
        public ?BasicStatus $status,

        public string $preview,

        public ?ThemeSettings $settings,

        public ?AddonRepository $repository
    ) {}
}
