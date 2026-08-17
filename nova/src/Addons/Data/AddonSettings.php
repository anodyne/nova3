<?php

declare(strict_types=1);

namespace Nova\Addons\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(array $settings)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class AddonSettings extends Bag
{
    public function __construct(
        public array $settings = []
    ) {}

    public function hasSettings(): bool
    {
        return count($this->settings) > 0;
    }

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'settings' => $request->input('settings'),
        ];
    }
}
