<?php

declare(strict_types=1);

namespace Nova\Pages\Enums;

use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum PageVerb: string implements HasLabel
{
    use HasSelectOptions;

    case Delete = 'delete';

    case Get = 'get';

    case Post = 'post';

    case Put = 'put';

    public function color(): string
    {
        return match ($this) {
            self::Get => 'primary',
            self::Post => 'warning',
            self::Put => 'info',
            self::Delete => 'danger',
        };
    }

    public function getLabel(): ?string
    {
        return strtoupper($this->value);
    }
}
