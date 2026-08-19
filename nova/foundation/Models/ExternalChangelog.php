<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Nova\Foundation\Enums\CacheKeys;
use Nova\Foundation\Enums\ReleaseSeverity;

/**
 * @property int $id
 * @property string $version
 * @property string $series
 * @property ReleaseSeverity $severity
 * @property string $description
 * @property string|null $notes
 * @property array<array-key, mixed>|null $tags
 * @property CarbonImmutable $release_date
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 *
 * @method static Builder<static>|ExternalChangelog newModelQuery()
 * @method static Builder<static>|ExternalChangelog newQuery()
 * @method static Builder<static>|ExternalChangelog query()
 * @method static Builder<static>|ExternalChangelog whereCreatedAt($value)
 * @method static Builder<static>|ExternalChangelog whereDescription($value)
 * @method static Builder<static>|ExternalChangelog whereId($value)
 * @method static Builder<static>|ExternalChangelog whereNotes($value)
 * @method static Builder<static>|ExternalChangelog whereReleaseDate($value)
 * @method static Builder<static>|ExternalChangelog whereSeries($value)
 * @method static Builder<static>|ExternalChangelog whereSeverity($value)
 * @method static Builder<static>|ExternalChangelog whereTags($value)
 * @method static Builder<static>|ExternalChangelog whereUpdatedAt($value)
 * @method static Builder<static>|ExternalChangelog whereVersion($value)
 *
 * @mixin \Eloquent
 */
class ExternalChangelog extends Model
{
    protected $casts = [
        'release_date' => 'date',
        'severity' => ReleaseSeverity::class,
        'tags' => 'array',
    ];

    protected $fillable = [
        'version', 'series', 'description', 'notes', 'release_date', 'tags', 'severity',
    ];

    protected $table = 'external_changelog';

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
