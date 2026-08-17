<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Carbon\CarbonImmutable;
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereSeverity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereVersion($value)
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
