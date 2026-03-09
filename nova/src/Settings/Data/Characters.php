<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(bool $approvePrimary, bool $approveSecondary, bool $approveSupport, bool $enforceCharacterLimits, ?int $characterLimit, bool $autoAvailabilityForPrimary, bool $autoAvailabilityForSecondary, bool $autoAvailabilityForSupport)
 */
readonly class Characters extends Bag
{
    public function __construct(
        public bool $approvePrimary,
        public bool $approveSecondary,
        public bool $approveSupport,
        public bool $enforceCharacterLimits,
        public ?int $characterLimit,
        public bool $autoAvailabilityForPrimary,
        public bool $autoAvailabilityForSecondary,
        public bool $autoAvailabilityForSupport
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'approvePrimary' => $request->boolean('approve_primary'),
            'approveSecondary' => $request->boolean('approve_secondary'),
            'approveSupport' => $request->boolean('approve_support'),
            'enforceCharacterLimits' => $request->boolean('enforce_character_limits'),
            'characterLimit' => $request->integer('character_limit', 5),
            'autoAvailabilityForPrimary' => $request->boolean('auto_availability_primary'),
            'autoAvailabilityForSecondary' => $request->boolean('auto_availability_secondary'),
            'autoAvailabilityForSupport' => $request->boolean('auto_availability_support'),
        ];
    }
}
