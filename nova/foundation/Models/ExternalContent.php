<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ExternalContent extends Model
{
    protected $table = 'external_content';

    protected $fillable = ['key', 'value'];

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

            static::refreshCache();
        }
    }

    public static function refreshCache(): void
    {
        Cache::forget('external-content');

        Cache::rememberForever('external-content', function () {
            return DB::table('external_content')->get()->pluck('value', 'key')->toArray();
        });
    }
}
