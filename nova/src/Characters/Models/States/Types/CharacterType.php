<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Types;

use Spatie\ModelStates\State;

abstract class CharacterType extends State
{
    abstract public function color(): string;

    abstract public function name(): string;

    public function displayName(): string
    {
        return ucfirst($this->name());
    }
}
