<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

class TextColumnMacros
{
    public function titleColumn()
    {
        return function () {
            $this->size('md');
            $this->weight('medium');

            return $this;
        };
    }
}
