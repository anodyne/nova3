<?php

declare(strict_types=1);

namespace Nova\Addons\Data;

use Nova\Foundation\Rules\Boolean;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class AddonScaffoldingOptions extends Data
{
    public function __construct(
        public bool $hasDatabaseMigrations,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'hasDatabaseMigrations' => new Boolean,
        ];
    }
}
