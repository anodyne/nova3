<?php

declare(strict_types=1);

namespace Nova\Applications\Enums;

use Filament\Support\Contracts\HasLabel;
use Nova\Foundation\Concerns\HasSelectOptions;

enum ApplicationResult: string implements HasLabel
{
    use HasSelectOptions;

    case Accept = 'accept';

    case Deny = 'deny';

    case Pending = 'pending';

    public function bgColor(): string
    {
        return match ($this) {
            self::Accept => 'bg-success-500',
            self::Deny => 'bg-danger-500',
            self::Pending => 'bg-warning-500',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Accept => 'success',
            self::Deny => 'danger',
            self::Pending => 'warning',
        };
    }

    public function getShortLabel(): ?string
    {
        return ucfirst($this->value);
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Accept => 'Accepted',
            self::Deny => 'Denied',
            self::Pending => 'Pending',
            default => null
        };
    }

    public function getSummary(string $name): string
    {
        return sprintf(
            '%s has %s this application',
            $name,
            match ($this) {
                self::Accept => 'voted to accept',
                self::Deny => 'voted to deny',
                default => 'not voted on',
            }
        );
    }

    public static function noVote(string $name): string
    {
        return $name.' has not voted on this application';
    }
}
