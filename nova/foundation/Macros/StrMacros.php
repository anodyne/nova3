<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Closure;

class StrMacros
{
    public function readDuration(): Closure
    {
        return function ($text): int {
            $totalWords = str_word_count(implode(' ', $text));
            $minutesToRead = round($totalWords / 200);

            return (int) max(1, $minutesToRead);
        };
    }
}
