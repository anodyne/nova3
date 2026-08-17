<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Stories\Enums\PostTypeVisibility;

/**
 * @method static static from(string $name, string $key, ?string $description, BasicStatus $status, Fields $fields, Options $options, ?int $role_id, PostTypeVisibility $visibility, ?string $icon, ?string $color)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class PostTypeData extends Bag
{
    public function __construct(
        public string $name,
        public string $key,
        public ?string $description,
        public BasicStatus $status,
        public Fields $fields,
        public Options $options,
        public ?int $role_id,
        public PostTypeVisibility $visibility,
        public ?string $icon,
        public ?string $color,
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'key' => $request->input('key'),
            'description' => $request->input('description'),
            'status' => BasicStatus::tryFrom($request->boolean('status') ? 'active' : 'inactive'),
            'fields' => Fields::from(
                title: Field::from(
                    enabled: $request->boolean('fields.title.enabled'),
                    required: $request->boolean('fields.title.required')
                ),
                day: Field::from(
                    enabled: $request->boolean('fields.day.enabled'),
                    required: $request->boolean('fields.day.required')
                ),
                time: Field::from(
                    enabled: $request->boolean('fields.time.enabled'),
                    required: $request->boolean('fields.time.required')
                ),
                location: Field::from(
                    enabled: $request->boolean('fields.location.enabled'),
                    required: $request->boolean('fields.location.required')
                ),
                content: Field::from(
                    enabled: $request->boolean('fields.content.enabled'),
                    required: $request->boolean('fields.content.required')
                ),
                rating: Field::from(
                    enabled: $request->boolean('fields.rating.enabled'),
                    required: $request->boolean('fields.rating.required')
                ),
                summary: Field::from(
                    enabled: $request->boolean('fields.summary.enabled'),
                    required: $request->boolean('fields.summary.required')
                )
            ),
            'options' => Options::from($request),
            'role_id' => $request->input('role_id'),
            'visibility' => PostTypeVisibility::tryFrom($request->input('visibility')) ?? PostTypeVisibility::InCharacter,
            'icon' => $request->input('icon'),
            'color' => $request->input('color'),
        ];
    }
}
