<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 * @mixin IdeHelperActivity
 */
class Activity extends \Spatie\Activitylog\Models\Activity
{
    use HasUuids;
}
