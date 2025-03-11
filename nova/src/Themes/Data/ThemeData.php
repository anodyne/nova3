<?php

declare(strict_types=1);

namespace Nova\Themes\Data;

use Bag\Bag;
use Nova\Addons\Data\AddonRepository;
use Nova\Foundation\Enums\BasicStatus;

/**
 * @method static static from(string $name, ?string $location, ?string $version, ?string $credits, BasicStatus $status, string $preview, ?ThemeSettings $settings, ?AddonRepository $repository)
 */
readonly class ThemeData extends Bag
{
    public function __construct(
        public string $name,
        public ?string $location,
        public ?string $version,
        public ?string $credits,
        public BasicStatus $status,
        public string $preview,
        public ?ThemeSettings $settings,
        public ?AddonRepository $repository
    ) {}
}
