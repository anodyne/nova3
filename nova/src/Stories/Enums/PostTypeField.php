<?php

declare(strict_types=1);

namespace Nova\Stories\Enums;

use Closure;
use Filament\Support\Contracts\HasLabel;

enum PostTypeField: string implements HasLabel
{
    case Content = 'content';
    case Day = 'day';
    case Location = 'location';
    case Rating = 'rating';
    case Summary = 'summary';
    case Time = 'time';
    case Title = 'title';

    public function canBeDisabled(): bool
    {
        return match ($this) {
            self::Title => false,
            default => true,
        };
    }

    public function canBeRequired(): bool
    {
        return match ($this) {
            self::Rating => false,
            default => true,
        };
    }

    public function getLabel(): string
    {
        return ucfirst($this->value);
    }

    public function requiredValidationRule(): string|Closure
    {
        return match ($this) {
            self::Content, self::Summary => function ($attribute, $value, $fail) {
                $strippedContent = str($value)->pipe('strip_tags');

                if (blank($strippedContent)) {
                    $fail('The :attribute field is required.');
                }
            },
            default => 'required',
        };
    }
}
