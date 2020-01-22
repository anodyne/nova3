<?php

namespace Nova\Foundation\Macros;

use Nova\Foundation\Toast;

class RedirectResponseMacros
{
    public function withToast()
    {
        return function ($message) {
            resolve(Toast::class)
                ->withMessage($message)
                ->success();

            return $this;
        };
    }

    public function withErrorToast()
    {
        return function ($message) {
            resolve(Toast::class)
                ->withMessage($message)
                ->error();

            return $this;
        };
    }
}
