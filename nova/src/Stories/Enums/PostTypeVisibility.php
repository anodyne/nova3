<?php

declare(strict_types=1);

namespace Nova\Stories\Enums;

use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum PostTypeVisibility: string implements HasLabel
{
    use HasSelectOptions;

    case InCharacter = 'in-character';

    case OutOfCharacter = 'out-of-character';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::InCharacter => 'In character',
            self::OutOfCharacter => 'Out of character',
        };
    }

    public function htmlId(): ?string
    {
        return match ($this) {
            self::InCharacter => 'in_character',
            self::OutOfCharacter => 'out_of_character',
        };
    }
}
