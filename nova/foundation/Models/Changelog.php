<?php

declare(strict_types=1);

namespace Nova\Foundation\Models;

use Illuminate\Database\Eloquent\Model;
use Nova\Foundation\Casts\CsvCast;

class Changelog extends Model
{
    protected $table = 'external_changelog';

    protected $casts = [
        'release_date' => 'date',
        'tags' => CsvCast::class,
    ];
}
