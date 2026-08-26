<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Nova\Foundation\Models\Concerns\HasTableHelpers;

abstract class Model extends EloquentModel
{
    use HasTableHelpers;
    use HasUuids;
}
