<?php

declare(strict_types=1);

namespace Nova\Media\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 * @mixin IdeHelperMedia
 */
class Media extends \Spatie\MediaLibrary\MediaCollections\Models\Media
{
    use HasUuids;
}
