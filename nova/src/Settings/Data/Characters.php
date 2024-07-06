<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class Characters extends Data implements Arrayable
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

    public static function fromRequest(Request $request): static
    {
        return new self(
            approvePrimary: $request->boolean('approve_primary', true),
            approveSecondary: $request->boolean('approve_secondary', true),
            approveSupport: $request->boolean('approve_support', true),
            enforceCharacterLimits: $request->boolean('enforce_character_limits', true),
            characterLimit: $request->integer('character_limit', 5),
            autoAvailabilityForPrimary: $request->boolean('auto_availability_primary', true),
            autoAvailabilityForSecondary: $request->boolean('auto_availability_secondary', true),
            autoAvailabilityForSupport: $request->boolean('auto_availability_support', false)
        );
    }
}
