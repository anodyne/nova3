<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class Characters extends Data implements Arrayable
{
    public function __construct(
        public bool $allowCharacterCreation,
        public bool $allowSettingPrimaryCharacter,
        public bool $autoLinkCharacter,
        public int $characterLimit,
        public bool $enforceCharacterLimits,
        public bool $requireApprovalForCharacterCreation,
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            allowCharacterCreation: $request->boolean('allow_character_creation', false),
            allowSettingPrimaryCharacter: $request->boolean('allow_setting_primary_character', false),
            autoLinkCharacter: $request->boolean('auto_link_character', false),
            characterLimit: (int) $request->input('character_limit', 5),
            enforceCharacterLimits: $request->boolean('enforce_character_limits', false),
            requireApprovalForCharacterCreation: $request->boolean('require_approval_for_character_creation', false)
        );
    }
}
