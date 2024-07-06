<?php

declare(strict_types=1);

namespace Nova\Themes\Data;

use Illuminate\Http\Request;
use Nova\Themes\Enums\ThemeStatus;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;

class ThemeData extends Data
{
    public function __construct(
        public string $name,

        public ?string $location,

        public ?string $credits,

        #[Enum(ThemeStatus::class)]
        public ?ThemeStatus $status,

        public string $preview,

        public ?array $variants,
    ) {}

    public static function fromArray(array $data): static
    {
        return new self(
            status: ThemeStatus::tryFrom(data_get($data, 'status', ThemeStatus::active->value)),
            credits: data_get($data, 'credits'),
            location: data_get($data, 'location'),
            name: data_get($data, 'name'),
            preview: data_get($data, 'preview', 'preview.jpg'),
            variants: explode(',', data_get($data, 'variants', ' ')),
        );
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            status: ThemeStatus::tryFrom($request->input('status', ThemeStatus::active->value)),
            credits: $request->input('credits'),
            location: $request->input('location'),
            name: $request->input('name'),
            preview: $request->input('preview', 'preview.jpg'),
            variants: $request->input('variants') !== null ? explode(',', $request->input('variants')) : null,
        );
    }
}
