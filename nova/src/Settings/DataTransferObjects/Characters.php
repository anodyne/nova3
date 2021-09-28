<?php

declare(strict_types=1);

namespace Nova\Settings\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class Characters extends CastableDataTransferObject implements Arrayable
{
    public bool $allowCharacterCreation;

    public bool $autoLinkCharacter;

    public int $characterLimit = 5;

    public bool $enforceCharacterLimits;

    public bool $requireApprovalForCharacterCreation;

    public static function fromRequest(Request $request): self
    {
        return new self(
            allowCharacterCreation: (bool) $request->input('allow_character_creation', false),
            autoLinkCharacter: (bool) $request->input('auto_link_character', false),
            characterLimit: (int) $request->input('character_limit', 5),
            enforceCharacterLimits: (bool) $request->input('enforce_character_limits', false),
            requireApprovalForCharacterCreation: (bool) $request->input('require_approval_for_character_creation', false)
        );
    }
}
