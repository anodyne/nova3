<?php

declare(strict_types=1);

namespace Nova\Roles\Data;

use Illuminate\Http\Request;
use Nova\Foundation\Rules\Boolean;
use Spatie\LaravelData\Data;

class RoleData extends Data
{
    public function __construct(
        public string $name,
        public string $display_name,
        public ?string $description,
        public bool $default,
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            name: $request->input('name'),
            display_name: $request->input('display_name'),
            description: $request->input('description'),
            default: $request->boolean('default', false),
        );
    }

    public static function rules(): array
    {
        return [
            'default' => [new Boolean()],
        ];
    }
}
