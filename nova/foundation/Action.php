<?php

namespace Nova\Foundation;

use Throwable;
use Nova\Foundation\Exceptions\ActionException;

abstract class Action
{
    public $errorMessage = null;

    final public function call($callback)
    {
        try {
            return $callback();
        } catch (Throwable $th) {
            $message = (is_null($this->errorMessage)) ? $th->getMessage() : $this->errorMessage;

            throw new ActionException($message);
        }
    }
}
