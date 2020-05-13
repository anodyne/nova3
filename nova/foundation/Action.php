<?php

namespace Nova\Foundation;

use Throwable;
use Nova\Foundation\Exceptions\ActionException;

abstract class Action
{
    /**
     * @var  string|null
     */
    public $errorMessage = null;

    /**
     * Call the passed callback within a try/catch block and throw an
     * exception if there's a problem.
     *
     *
     * @param  callable  $callback
     *
     * @throws ActionException
     *
     * @return mixed
     */
    final public function call($callback)
    {
        try {
            return $callback();
        } catch (Throwable $th) {
            logger()->error($th->getMessage());

            throw new ActionException($this->getErrorMessage($th));
        }
    }

    /**
     * Get the error message.
     *
     * @param  Throwable|null  $throwable
     *
     * @return string
     */
    protected function getErrorMessage($throwable = null): string
    {
        if (! app()->environment('production') || $this->errorMessage === null) {
            return $throwable->getMessage();
        }

        return $this->errorMessage;
    }
}
