<?php

declare(strict_types=1);

namespace Nova\Stories\Enums;

use Filament\Support\Contracts\HasLabel;

enum PostTypeField: string implements HasLabel
{
    case Title = 'title';

    case Location = 'location';

    case Day = 'day';

    case Time = 'time';

    case Content = 'content';

    case Rating = 'rating';

    case Summary = 'summary';

    public function getLabel(): ?string
    {
        return ucfirst($this->value);
    }

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

    public function requiredValidationRule(): mixed
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
