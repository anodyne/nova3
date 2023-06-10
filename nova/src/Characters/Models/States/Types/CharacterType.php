<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Types;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class CharacterType extends State
{
    abstract public function color(): string;

    abstract public function name(): string;

    public function getLabel(): string
    {
        return ucfirst($this->name());
    }

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Support::class)
            ->allowTransitions([
                [Primary::class, Support::class],
                [Primary::class, Secondary::class],

                [Support::class, Secondary::class],
                [Support::class, Primary::class],

                [Secondary::class, Support::class],
                [Secondary::class, Primary::class],
            ]);
    }
}
