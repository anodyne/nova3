<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Closure;
use Filament\Tables\Columns\TextColumn;

/** @mixin TextColumn */
class TextColumnMacros
{
    public function titleColumn(): Closure
    {
        /** @this TextColumn */
        return function () {
            $this->weight('medium');
            $this->extraAttributes(['class' => 'fi-ta-title-column']);

            return $this;
        };
    }
}
