<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{
    use HasTableHelpers;
}
