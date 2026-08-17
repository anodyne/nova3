<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Nova\Foundation\Enums\CacheKeys;

/**
 * @property int $id
 * @property string $key
 * @property string $value
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalContent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalContent whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalContent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalContent whereValue($value)
 *
 * @mixin \Eloquent
 */
class ExternalContent extends Model
{
    protected $fillable = ['key', 'value'];

    protected $table = 'external_content';

    public static function syncFromAnodyne(): void
    {
        $content = Http::get(config('services.anodyne.external.content'));

        if ($content->ok()) {
            foreach ($content->collect('content') as $key => $value) {
                ExternalContent::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            Cache::forget(CacheKeys::ExternalContent->value);
        }
    }
}
