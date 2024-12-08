<?php

declare(strict_types=1);

namespace Nova\Foundation\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait ChecksAddonVersion
{
    abstract public function addonVersionCacheKey(): string;

    public function latestVersion(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => data_get(cache($this->addonVersionCacheKey()), $this->repository?->id.'.version')
        );
    }

    public function hasUpdate(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => version_compare($this->version, $this->latest_version ?? '0.0', '<') ?? false
        );
    }

    public function updateUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => data_get(cache($this->addonVersionCacheKey()), $this->repository?->id.'.url')
        );
    }
}
