<?php

declare(strict_types=1);

namespace Nova\Foundation\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait ChecksAddonVersion
{
    abstract public function addonVersionCacheKey(): string;

    /** @return Attribute<string|null, never> */
    public function latestVersion(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => data_get(cache($this->addonVersionCacheKey()), $this->repository?->id.'.version')
        );
    }

    /** @return Attribute<bool, never> */
    public function hasUpdate(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => version_compare($this->version, $this->latest_version ?? '0.0', '<')
        );
    }

    /** @return Attribute<string|null, never> */
    public function updateUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => data_get(cache($this->addonVersionCacheKey()), $this->repository?->id.'.url')
        );
    }
}
