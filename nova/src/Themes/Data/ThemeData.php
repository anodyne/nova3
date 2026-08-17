<?php

declare(strict_types=1);

namespace Nova\Themes\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Addons\Data\AddonRepository;
use Nova\Foundation\Enums\BasicStatus;

/**
 * @method static static from(string $name, ?string $location, ?string $version, ?string $credits, BasicStatus $status, string $preview, ?ThemeSettings $settings, ?AddonRepository $repository)
 *
 * @phpstan-method static static from(mixed ...$values)
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

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'version' => $request->input('version'),
            'credits' => $request->input('credits'),
            'status' => BasicStatus::tryFrom($request->boolean('status') ? 'active' : 'inactive'),
            'preview' => $request->input('preview'),
            'settings' => ThemeSettings::from(fonts: $request->array('settings.fonts'), settings: []),
        ];
    }
}
