<?php

declare(strict_types=1);

namespace Nova\Ranks\Models\States\Names;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class RankNameStatus extends State
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
            ->default(Active::class)
            ->allowTransitions([
                [Active::class, Inactive::class],
            ]);
    }
}
