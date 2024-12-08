<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Nova\Foundation\Casts\CsvCast;

class ExternalChangelog extends Model
{
    protected $table = 'external_changelog';

    protected $fillable = [
        'version', 'series', 'description', 'notes', 'release_date', 'tags',
    ];

    protected $casts = [
        'release_date' => 'date',
        'tags' => CsvCast::class,
    ];

    public static function syncFromAnodyne(): void
    {
        $changelog = Http::get(config('services.anodyne.external.changelog'));

        if ($changelog->ok()) {
            foreach ($changelog as $version) {
                ExternalChangelog::updateOrCreate(
                    ['version' => $version['version']],
                    Arr::except($version, 'version')
                );
            }
        }
    }
}
