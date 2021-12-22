<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Nova\Foundation\Toast;

class ToastMacros
{
    public function withToast()
    {
        return function ($title, $message = null) {
            app(Toast::class)
                ->withTitle($title)
                ->withMessage($message)
                ->success();

            return $this;
        };
    }

    public function withErrorToast()
    {
        return function ($title, $message = null) {
            app(Toast::class)
                ->withTitle($title)
                ->withMessage($message)
                ->error();

            return $this;
        };
    }
}
