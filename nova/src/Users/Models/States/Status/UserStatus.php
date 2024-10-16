<?php

declare(strict_types=1);

namespace Nova\Users\Models\States\Status;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class UserStatus extends State
{
    abstract public function color(): string;

    abstract public function bgColor(): string;

    abstract public function name(): string;

    abstract public function simple(): string;

    public function getLabel(): string
    {
        return ucfirst($this->name());
    }

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransitions([
                [Pending::class, Active::class, PendingToActive::class],
                [Pending::class, Inactive::class],
                [Pending::class, Hidden::class],
                [Active::class, Inactive::class, ActiveToInactive::class],
                [Inactive::class, Active::class, InactiveToActive::class],
            ]);
    }
}
