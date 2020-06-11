<?php

namespace Nova\Users\Models\States;

use Spatie\ModelStates\State;

abstract class UserState extends State
{
    abstract public function name(): string;

    abstract public function statusClass(): string;
}
