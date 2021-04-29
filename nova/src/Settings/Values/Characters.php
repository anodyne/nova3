<?php

namespace Nova\Settings\Values;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class Characters extends CastableDataTransferObject implements Arrayable
{
    public bool $allowCharacterCreation;

    public bool $requireApprovalForCharacterCreation;

    public bool $enforceCharacterLimits;

    public int $characterLimit = 5;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'allowCharacterCreation' => (bool) $request->input('allowCharacterCreation', false),
            'requireApprovalForCharacterCreation' => (bool) $request->input('requireApprovalForCharacterCreation', false),
            'enforceCharacterLimits' => (bool) $request->input('enforceCharacterLimits', false),
            'characterLimit' => (int) $request->input('characterLimit', 5),
        ]);
    }
}
