<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class ExternalContent extends Model
{
    protected $table = 'external_content';

    protected $fillable = ['key', 'value'];

    public static function syncFromAnodyne(): void
    {
        $content = Http::get(config('services.anodyne.external.content'));

        if ($content->ok()) {
            foreach ($content as $content) {
                ExternalContent::updateOrCreate(
                    ['key' => $content['key']],
                    ['value' => $content['value']]
                );
            }
        }
    }
}
