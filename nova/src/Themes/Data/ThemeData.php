<?php

declare(strict_types=1);

namespace Nova\Themes\Data;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class ThemeData extends Data
{
    public function __construct(
        public string $name,
        public ?string $location,
        public ?string $credits,
        public bool $active = true,
        public string $preview = 'preview.jpg',
        public ?array $variants,
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            active: (bool) ($request->active ?? true),
            credits: $request->credits,
            location: $request->location,
            name: $request->name,
            preview: $request->preview ?? 'preview.jpg',
            variants: explode(',', $request->input('variants', '')),
        );
    }
}
