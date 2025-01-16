<?php

declare(strict_types=1);

namespace Nova\Foundation\Values;

use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Date;
use Livewire\Wireable;
use Nova\Foundation\Enums\ReleaseSeverity;

class LatestVersion implements Wireable
{
    public function __construct(
        public readonly string $version,
        public readonly CarbonInterface $date,
        public readonly ReleaseSeverity $severity,
        public readonly ?string $notes,
        public readonly ?string $details,
        public readonly array $tags,
        public readonly ?string $downloadLink
    ) {}

    public static function fromAnodyne(array $data): static
    {
        return new static(
            version: data_get($data, 'version'),
            date: Date::parse(data_get($data, 'date')),
            severity: ReleaseSeverity::tryFrom(data_get($data, 'severity', 'patch')),
            notes: data_get($data, 'notes'),
            details: data_get($data, 'details'),
            tags: data_get($data, 'tags', []),
            downloadLink: data_get($data, 'link')
        );
    }

    public static function fromGithub(array $data): static
    {
        return new static(
            version: data_get($data, 'name'),
            date: Date::parse(data_get($data, 'published_at')),
            severity: ReleaseSeverity::Patch,
            notes: null,
            details: data_get($data, 'body'),
            tags: [],
            downloadLink: data_get($data, 'html_url')
        );
    }

    public function toLivewire()
    {
        return [
            'version' => $this->version,
            'date' => $this->date,
            'severity' => $this->severity,
            'notes' => $this->notes,
            'details' => $this->details,
            'tags' => $this->tags,
            'downloadLink' => $this->downloadLink,
        ];
    }

    public static function fromLivewire($value)
    {
        return new static(
            version: data_get($value, 'name'),
            date: Date::parse(data_get($value, 'date')),
            severity: ReleaseSeverity::tryFrom(data_get($value, 'severity')),
            notes: data_get($value, 'notes'),
            details: data_get($value, 'details'),
            tags: data_get($value, 'tags', []),
            downloadLink: data_get($value, 'downloadLink')
        );
    }
}
