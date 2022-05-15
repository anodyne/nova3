<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Statuses;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class CharacterStatus extends State
{
    abstract public function color(): string;

    abstract public function bgColor(): string;

    abstract public function name(): string;

    public function displayName(): string
    {
        return ucfirst($this->name());
    }

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransitions([
                [Pending::class, Active::class],
                [Pending::class, Inactive::class],
                [Active::class, Inactive::class, ActiveToInactive::class],
                [Inactive::class, Active::class],
            ]);
    }
}
