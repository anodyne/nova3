<?php

declare(strict_types=1);

namespace Nova\Roles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laratrust\Models\Team as LaratrustTeam;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Concerns\HasTableHelpers;

class Team extends LaratrustTeam
{
    use HasFactory;
    use HasTableHelpers;
    use LogsActivity;

    protected $fillable = [
        'name', 'display_name', 'description',
    ];
}
