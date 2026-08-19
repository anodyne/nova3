<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
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
 * @method static Builder<static>|ExternalContent newModelQuery()
 * @method static Builder<static>|ExternalContent newQuery()
 * @method static Builder<static>|ExternalContent query()
 * @method static Builder<static>|ExternalContent whereCreatedAt($value)
 * @method static Builder<static>|ExternalContent whereId($value)
 * @method static Builder<static>|ExternalContent whereKey($value)
 * @method static Builder<static>|ExternalContent whereUpdatedAt($value)
 * @method static Builder<static>|ExternalContent whereValue($value)
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
