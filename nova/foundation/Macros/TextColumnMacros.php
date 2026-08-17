<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Closure;
use Filament\Tables\Columns\TextColumn;

class TextColumnMacros
{
    public function titleColumn(): Closure
    {
        return function () {
            /** @var TextColumn $column */
            $column = $this;

            $column->weight('medium');
            $column->extraAttributes(['class' => 'fi-ta-title-column']);

            return $column;
        };
    }
}
