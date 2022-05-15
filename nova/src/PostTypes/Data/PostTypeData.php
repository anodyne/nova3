<?php

declare(strict_types=1);

namespace Nova\PostTypes\Data;

use Illuminate\Http\Request;
use Nova\PostTypes\Models\States\Active;
use Spatie\LaravelData\Data;

class PostTypeData extends Data
{
    public function __construct(
        public string $name,
        public string $key,
        public ?string $description,
        public string $status,
        public Fields $fields,
        public Options $options,
        public ?int $role_id,
        public string $visibility,
        public ?string $icon,
        public ?string $color,
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            status: $request->input('status', Active::class),
            color: $request->color,
            description: $request->description,
            fields: Fields::from($request->fields),
            icon: $request->icon,
            key: $request->key,
            name: $request->name,
            options: Options::from($request->options),
            role_id: (int) $request->role_id,
            visibility: $request->visibility,
        );
    }
}
