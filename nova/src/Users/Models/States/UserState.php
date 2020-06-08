<?php

namespace Nova\Users\Models\States;

use Spatie\ModelStates\State;

abstract class UserState extends State
{
    abstract public function statusClass(): string;

    public function status(): string
    {
        return static::$name;
    }
}
