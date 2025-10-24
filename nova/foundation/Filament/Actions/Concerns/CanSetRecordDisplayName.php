<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions\Concerns;

trait CanSetRecordDisplayName
{
    protected ?string $recordDisplayNameAttribute = null;

    public function recordDisplayNameAttribute(string $attribute): self
    {
        $this->recordDisplayNameAttribute = $attribute;

        return $this;
    }

    public function getRecordDisplayNameAttribute(): ?string
    {
        return $this->recordDisplayNameAttribute;
    }
}
