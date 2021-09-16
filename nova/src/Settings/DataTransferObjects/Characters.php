<?php

declare(strict_types=1);

namespace Nova\Settings\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class Characters extends CastableDataTransferObject implements Arrayable
{
    public bool $allowCharacterCreation;

    public int $characterLimit = 5;

    public bool $enforceCharacterLimits;

    public bool $requireApprovalForCharacterCreation;

    public static function fromRequest(Request $request): self
    {
        return new self(
            allowCharacterCreation: (bool) $request->input('allowCharacterCreation', false),
            characterLimit: (int) $request->input('characterLimit', 5),
            enforceCharacterLimits: (bool) $request->input('enforceCharacterLimits', false),
            requireApprovalForCharacterCreation: (bool) $request->input('requireApprovalForCharacterCreation', false)
        );
    }
}
