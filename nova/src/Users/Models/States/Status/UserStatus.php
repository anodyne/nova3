<?php

declare(strict_types=1);

namespace Nova\Users\Models\States\Status;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Nova\Users\Models\User;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

/** @extends State<User> */
abstract class UserStatus extends State implements HasColor, HasLabel
{
    abstract public function bgColor(): string;

    abstract public function name(): string;

    abstract public function simple(): string;

    abstract public function getColor(): string;

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
                [Pending::class, Banned::class],
                [Active::class, Inactive::class, ActiveToInactive::class],
                [Active::class, Banned::class],
                [Inactive::class, Active::class, InactiveToActive::class],
                [Inactive::class, Banned::class],
                [Hidden::class, Banned::class],
                [Banned::class, Active::class],
                [Banned::class, Inactive::class],
            ]);
    }
}
