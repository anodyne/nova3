<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Nova\Foundation\Enums\CacheKeys;
use Nova\Foundation\Enums\ReleaseSeverity;

class ExternalChangelog extends Model
{
    protected $table = 'external_changelog';

    protected $fillable = [
        'version', 'series', 'description', 'notes', 'release_date', 'tags', 'severity',
    ];

    protected $casts = [
        'release_date' => 'date',
        'severity' => ReleaseSeverity::class,
        'tags' => 'array',
    ];

    public static function syncFromAnodyne(): void
    {
        $changelog = Http::get(config('services.anodyne.external.changelog'));

        if ($changelog->ok()) {
            foreach ($changelog->collect('data') as $version) {
                ExternalChangelog::updateOrCreate(
                    ['version' => $version['version']],
                    Arr::except($version, 'version')
                );
            }

            Cache::forget(CacheKeys::ExternalChangelog->value);
        }
    }
}
