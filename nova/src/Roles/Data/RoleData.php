<?php

declare(strict_types=1);

namespace Nova\Roles\Data;

use Illuminate\Validation\Rule;
use Nova\Foundation\Rules\Boolean;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Support\Validation\ValidationContext;

#[MapName(SnakeCaseMapper::class)]
class RoleData extends Data
{
    public function __construct(
        public string $name,
        public string $displayName,
        public ?string $description,
        public bool $isDefault = false,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'name' => Rule::unique('roles')->ignore(request()->role),
            'is_default' => new Boolean,
        ];
    }
}
