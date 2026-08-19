<?php

declare(strict_types=1);

namespace Nova\Settings\Enums;

use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum PostingTarget: string implements HasLabel
{
    use HasSelectOptions;

    case Posts = 'posts';
    case Words = 'words';

    public function getLabel(): string
    {
        return ucfirst($this->value);
    }
}
