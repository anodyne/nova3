<?php

namespace Nova\Foundation\Macros;

class StrMacros
{
    public function readDuration()
    {
        return function ($text) {
            $totalWords = str_word_count(implode(' ', $text));
            $minutesToRead = round($totalWords / 200);

            return (int) max(1, $minutesToRead);
        };
    }
}
