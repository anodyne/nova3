<?php

declare(strict_types=1);

namespace Nova\Addons\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Addons\Enums\AddonType;
use Nova\Foundation\Enums\BasicStatus;

/**
 * @method static static from(string $name, string $location, string $version, ?string $credits, AddonType $type, BasicStatus $status, ?string $preview, ?AddonSettings $settings, ?AddonRepository $repository)
 */
readonly class AddonData extends Bag
{
    public function __construct(
        public string $name,
        public string $location,
        public string $version,
        public ?string $credits,
        public AddonType $type,
        public BasicStatus $status,
        public ?string $preview,
        public ?AddonSettings $settings,
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
            'type' => AddonType::tryFrom($request->input('type')) ?? AddonType::Extension,
            'status' => BasicStatus::tryFrom($request->boolean('status') ? 'active' : 'inactive'),
            'preview' => $request->input('preview'),
            'settings' => AddonSettings::from(settings: $request->input('settings') ?? []),
            'repository' => $request->has('repository') ? AddonRepository::from($request->input('repository')) : null,
        ];
    }
}
