<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Status;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class CharacterStatus extends State implements HasColor, HasLabel
{
    abstract public function bgColor(): string;

    abstract public function name(): string;

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
                [Active::class, Pending::class],
                [Active::class, Inactive::class, ActiveToInactive::class],
                [Inactive::class, Active::class, InactiveToActive::class],
            ]);
    }
}
