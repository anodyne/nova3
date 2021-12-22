<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FormBlock extends Pivot
{
    protected $table = 'form_block';
}
