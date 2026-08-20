<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Nova\Foundation\Enums\CacheKeys;

/**
 * @mixin IdeHelperExternalContent
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
